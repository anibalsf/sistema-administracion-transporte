from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from django.db.models import Sum
from django.utils import timezone
from datetime import datetime, timedelta
from .models import TipoPago, Pago, Egreso
from .serializers import (
    TipoPagoSerializer, PagoSerializer, PagoDetailSerializer, EgresoSerializer
)

class TipoPagoViewSet(viewsets.ModelViewSet):
    """ViewSet for TipoPago CRUD operations"""
    
    queryset = TipoPago.objects.all()
    serializer_class = TipoPagoSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['categoria', 'activo']
    search_fields = ['nombre']
    ordering = ['categoria', 'nombre']


class PagoViewSet(viewsets.ModelViewSet):
    """ViewSet for Pago CRUD operations"""
    
    queryset = Pago.objects.select_related('afiliado', 'tipo_pago').all()
    serializer_class = PagoSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['afiliado', 'tipo_pago', 'fecha_pago', 'es_mora']
    search_fields = ['afiliado__nombre', 'afiliado__apellido', 'numero_recibo', 'codigo_qr']
    ordering_fields = ['fecha_pago', 'monto']
    ordering = ['-fecha_pago']
    
    def get_serializer_class(self):
        if self.action == 'retrieve':
            return PagoDetailSerializer
        return PagoSerializer
    
    @action(detail=False, methods=['get'])
    def reporte_mensual(self, request):
        """Get monthly payment report"""
        # Get month and year from query params
        mes = request.query_params.get('mes', timezone.now().month)
        anio = request.query_params.get('anio', timezone.now().year)
        
        pagos = self.queryset.filter(
            fecha_pago__month=mes,
            fecha_pago__year=anio
        )
        
        total = pagos.aggregate(total=Sum('monto'))['total'] or 0
        total_mora = pagos.aggregate(total_mora=Sum('monto_mora'))['total_mora'] or 0
        
        return Response({
            'mes': mes,
            'anio': anio,
            'total_pagos': pagos.count(),
            'total_ingresos': float(total),
            'total_mora': float(total_mora),
            'gran_total': float(total + total_mora),
            'pagos': self.get_serializer(pagos, many=True).data
        })
    
    @action(detail=False, methods=['get'])
    def deudores(self, request):
        """Get list of affiliates with pending payments"""
        # This is a placeholder - would need more complex logic
        from apps.afiliados.models import Afiliado
        from apps.afiliados.serializers import AfiliadoListSerializer
        
        # Get all active affiliates
        afiliados = Afiliado.objects.filter(estado='activo')
        
        # TODO: Implement logic to determine deudores
        # For now, just return all active affiliates
        serializer = AfiliadoListSerializer(afiliados, many=True)
        return Response(serializer.data)


class EgresoViewSet(viewsets.ModelViewSet):
    """ViewSet for Egreso CRUD operations"""
    
    queryset = Egreso.objects.all()
    serializer_class = EgresoSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['fecha_egreso', 'responsable']
    search_fields = ['concepto', 'responsable', 'comprobante']
    ordering_fields = ['fecha_egreso', 'monto']
    ordering = ['-fecha_egreso']
    
    @action(detail=False, methods=['get'])
    def reporte_mensual(self, request):
        """Get monthly expense report"""
        mes = request.query_params.get('mes', timezone.now().month)
        anio = request.query_params.get('anio', timezone.now().year)
        
        egresos = self.queryset.filter(
            fecha_egreso__month=mes,
            fecha_egreso__year=anio
        )
        
        total = egresos.aggregate(total=Sum('monto'))['total'] or 0
        
        return Response({
            'mes': mes,
            'anio': anio,
            'total_egresos': egresos.count(),
            'total_monto': float(total),
            'egresos': self.get_serializer(egresos, many=True).data
        })
