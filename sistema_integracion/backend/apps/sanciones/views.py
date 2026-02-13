from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from django.utils import timezone
from .models import Reunion, Asistencia, Sancion
from .serializers import ReunionSerializer, AsistenciaSerializer, SancionSerializer

class ReunionViewSet(viewsets.ModelViewSet):
    """ViewSet for Reunion CRUD operations"""
    
    queryset = Reunion.objects.all()
    serializer_class = ReunionSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['asistencia_obligatoria', 'fecha_reunion']
    search_fields = ['titulo', 'lugar']
    ordering_fields = ['fecha_reunion']
    ordering = ['-fecha_reunion']
    
    @action(detail=True, methods=['post'])
    def registrar_asistencia_masiva(self, request, pk=None):
        """Register attendance for all active affiliates"""
        reunion = self.get_object()
        from apps.afiliados.models import Afiliado
        afiliados = Afiliado.objects.filter(estado='activo')
        
        creadas = 0
        for afiliado in afiliados:
            _, created = Asistencia.objects.get_or_create(
                reunion=reunion,
                afiliado=afiliado,
                defaults={'estado': 'falto'}
            )
            if created:
                creadas += 1
        
        return Response({
            'message': f'{creadas} registros de asistencia creados',
            'total_afiliados': afiliados.count()
        })


class AsistenciaViewSet(viewsets.ModelViewSet):
    """ViewSet for Asistencia CRUD operations"""
    
    queryset = Asistencia.objects.select_related('reunion', 'afiliado').all()
    serializer_class = AsistenciaSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['reunion', 'afiliado', 'estado']
    search_fields = ['afiliado__nombre', 'afiliado__apellido']
    ordering = ['-created_at']


class SancionViewSet(viewsets.ModelViewSet):
    """ViewSet for Sancion CRUD operations"""
    
    queryset = Sancion.objects.select_related('afiliado', 'asistencia').all()
    serializer_class = SancionSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['afiliado', 'estado', 'fecha_sancion']
    search_fields = ['afiliado__nombre', 'afiliado__apellido', 'motivo']
    ordering_fields = ['fecha_sancion', 'monto']
    ordering = ['-fecha_sancion']
    
    @action(detail=False, methods=['get'])
    def pendientes(self, request):
        """Get pending sanctions"""
        pendientes = self.queryset.filter(estado='pendiente')
        serializer = self.get_serializer(pendientes, many=True)
        return Response(serializer.data)
    
    @action(detail=True, methods=['post'])
    def marcar_pagado(self, request, pk=None):
        """Mark sanction as paid"""
        sancion = self.get_object()
        sancion.estado = 'pagado'
        sancion.fecha_pago = timezone.now().date()
        sancion.save()
        
        return Response({
            'message': 'Sanción marcada como pagada',
            'sancion': self.get_serializer(sancion).data
        })
