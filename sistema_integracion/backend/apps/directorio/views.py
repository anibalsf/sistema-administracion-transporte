from rest_framework import viewsets, filters
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from django.utils import timezone
from .models import Directorio
from .serializers import DirectorioSerializer, DirectorioDetailSerializer

class DirectorioViewSet(viewsets.ModelViewSet):
    """
    ViewSet for Directorio CRUD operations
    """
    
    queryset = Directorio.objects.select_related('afiliado').all()
    serializer_class = DirectorioSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['cargo', 'estado', 'gestion_inicio']
    search_fields = ['afiliado__nombre', 'afiliado__apellido', 'cargo']
    ordering_fields = ['gestion_inicio', 'cargo']
    ordering = ['-gestion_inicio']
    
    def get_serializer_class(self):
        if self.action == 'retrieve':
            return DirectorioDetailSerializer
        return DirectorioSerializer
    
    @action(detail=False, methods=['get'])
    def vigente(self, request):
        """Get current board (vigente)"""
        today = timezone.now().date()
        vigentes = self.queryset.filter(
            estado='vigente',
            gestion_inicio__lte=today,
            gestion_fin__gte=today
        )
        serializer = self.get_serializer(vigentes, many=True)
        return Response(serializer.data)
    
    @action(detail=False, methods=['get'])
    def historial(self, request):
        """Get board history (finalizados)"""
        finalizados = self.queryset.filter(estado='finalizado').order_by('-gestion_fin')
        serializer = self.get_serializer(finalizados, many=True)
        return Response(serializer.data)
