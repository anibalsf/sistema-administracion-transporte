from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from django.utils import timezone
from .models import Reserva
from .serializers import ReservaSerializer, ReservaDetailSerializer

class ReservaViewSet(viewsets.ModelViewSet):
    """ViewSet for Reserva CRUD operations"""
    
    queryset = Reserva.objects.select_related('vehiculo', 'afiliado', 'ruta').all()
    serializer_class = ReservaSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['vehiculo', 'afiliado', 'ruta', 'estado', 'fecha_viaje']
    search_fields = ['pasajero_nombre', 'pasajero_ci', 'pasajero_telefono']
    ordering_fields = ['fecha_viaje', 'created_at']
    ordering = ['-fecha_viaje']
    
    def get_serializer_class(self):
        if self.action == 'retrieve':
            return ReservaDetailSerializer
        return ReservaSerializer
    
    @action(detail=True, methods=['post'])
    def cancelar(self, request, pk=None):
        """Cancel a reservation"""
        reserva = self.get_object()
        reserva.estado = 'cancelada'
        reserva.save()
        
        return Response({
            'message': 'Reserva cancelada exitosamente',
            'reserva': self.get_serializer(reserva).data
        })
    
    @action(detail=True, methods=['post'])
    def completar(self, request, pk=None):
        """Mark reservation as completed"""
        reserva = self.get_object()
        reserva.estado = 'completada'
        reserva.save()
        
        return Response({
            'message': 'Reserva completada exitosamente',
            'reserva': self.get_serializer(reserva).data
        })
    
    @action(detail=False, methods=['get'])
    def hoy(self, request):
        """Get today's reservations"""
        today = timezone.now().date()
        reservas_hoy = self.queryset.filter(
            fecha_viaje__date=today,
            estado='confirmada'
        )
        serializer = self.get_serializer(reservas_hoy, many=True)
        return Response(serializer.data)
    
    @action(detail=False, methods=['get'])
    def proximas(self, request):
        """Get upcoming reservations"""
        now = timezone.now()
        proximas = self.queryset.filter(
            fecha_viaje__gte=now,
            estado='confirmada'
        ).order_by('fecha_viaje')
        serializer = self.get_serializer(proximas, many=True)
        return Response(serializer.data)
    
    @action(detail=False, methods=['get'])
    def asientos_disponibles(self, request):
        """Get available seats for a vehicle on a specific date"""
        vehiculo_id = request.query_params.get('vehiculo')
        fecha = request.query_params.get('fecha')
        
        if not vehiculo_id or not fecha:
            return Response(
                {'error': 'vehiculo y fecha son requeridos'},
                status=status.HTTP_400_BAD_REQUEST
            )
        
        from apps.vehiculos.models import Vehiculo
        try:
            vehiculo = Vehiculo.objects.get(id=vehiculo_id)
        except Vehiculo.DoesNotExist:
            return Response(
                {'error': 'Vehículo no encontrado'},
                status=status.HTTP_404_NOT_FOUND
            )
        
        # Get reserved seats
        reservas = self.queryset.filter(
            vehiculo_id=vehiculo_id,
            fecha_viaje__date=fecha,
            estado__in=['confirmada', 'completada']
        ).values_list('asiento_numero', flat=True)
        
        asientos_ocupados = list(reservas)
        asientos_disponibles = [
            i for i in range(1, vehiculo.capacidad + 1)
            if i not in asientos_ocupados
        ]
        
        return Response({
            'vehiculo': vehiculo.placa,
            'capacidad_total': vehiculo.capacidad,
            'asientos_ocupados': asientos_ocupados,
            'asientos_disponibles': asientos_disponibles,
            'total_disponibles': len(asientos_disponibles)
        })
