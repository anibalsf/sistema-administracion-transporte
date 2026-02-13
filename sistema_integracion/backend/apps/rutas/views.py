from rest_framework import viewsets, filters
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from .models import Ruta
from .serializers import RutaSerializer

class RutaViewSet(viewsets.ModelViewSet):
    """
    ViewSet for Ruta CRUD operations
    """
    
    queryset = Ruta.objects.all()
    serializer_class = RutaSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['activa']
    search_fields = ['nombre_ruta']
    ordering_fields = ['nombre_ruta', 'precio']
    ordering = ['nombre_ruta']
    
    @action(detail=False, methods=['get'])
    def activas(self, request):
        """Get only active routes"""
        activas = self.queryset.filter(activa=True)
        serializer = self.get_serializer(activas, many=True)
        return Response(serializer.data)
