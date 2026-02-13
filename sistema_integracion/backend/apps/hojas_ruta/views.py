from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from django.utils import timezone
from .models import HojaRuta, AgenteParada
from .serializers import (
    HojaRutaSerializer, HojaRutaDetailSerializer, 
    HojaRutaCreateSerializer, AgenteParadaSerializer
)

class HojaRutaViewSet(viewsets.ModelViewSet):
    """
    ViewSet for HojaRuta CRUD operations
    """
    
    queryset = HojaRuta.objects.select_related(
        'vehiculo', 'afiliado', 'ruta', 'agente_parada'
    ).all()
    serializer_class = HojaRutaSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['vehiculo', 'afiliado', 'ruta', 'fecha_emision', 'enviado_whatsapp']
    search_fields = ['vehiculo__placa', 'afiliado__nombre', 'afiliado__apellido', 'codigo_qr']
    ordering_fields = ['fecha_emision', 'fecha_salida', 'monto']
    ordering = ['-fecha_emision']
    
    def get_serializer_class(self):
        if self.action == 'create':
            return HojaRutaCreateSerializer
        elif self.action == 'retrieve':
            return HojaRutaDetailSerializer
        return HojaRutaSerializer
    
    @action(detail=True, methods=['post'])
    def generar_pdf(self, request, pk=None):
        """Generate PDF for route sheet"""
        hoja = self.get_object()
        # TODO: Implement PDF generation with ReportLab
        # For now, just return placeholder
        pdf_url = f"/media/hojas_ruta/hoja_ruta_{hoja.id}.pdf"
        hoja.pdf_url = pdf_url
        hoja.save()
        
        return Response({
            'message': 'PDF generado exitosamente',
            'pdf_url': pdf_url
        })
    
    @action(detail=True, methods=['post'])
    def enviar_whatsapp(self, request, pk=None):
        """Send route sheet via WhatsApp"""
        hoja = self.get_object()
        # TODO: Implement WhatsApp sending with Twilio
        # For now, just mark as sent
        hoja.enviado_whatsapp = True
        hoja.fecha_envio_whatsapp = timezone.now()
        hoja.save()
        
        return Response({
            'message': 'Hoja de ruta enviada por WhatsApp exitosamente'
        })
    
    @action(detail=False, methods=['get'])
    def hoy(self, request):
        """Get today's route sheets"""
        today = timezone.now().date()
        hojas_hoy = self.queryset.filter(fecha_emision=today)
        serializer = self.get_serializer(hojas_hoy, many=True)
        return Response(serializer.data)


class AgenteParadaViewSet(viewsets.ModelViewSet):
    """
    ViewSet for AgenteParada CRUD operations
    """
    
    queryset = AgenteParada.objects.select_related('afiliado').all()
    serializer_class = AgenteParadaSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['afiliado', 'fecha_designacion']
    search_fields = ['afiliado__nombre', 'afiliado__apellido']
    ordering_fields = ['fecha_designacion']
    ordering = ['-fecha_designacion']
    
    @action(detail=False, methods=['get'])
    def hoy(self, request):
        """Get today's stop agent"""
        today = timezone.now().date()
        agente_hoy = self.queryset.filter(fecha_designacion=today).first()
        if agente_hoy:
            serializer = self.get_serializer(agente_hoy)
            return Response(serializer.data)
        return Response({'message': 'No hay agente designado para hoy'}, status=status.HTTP_404_NOT_FOUND)
