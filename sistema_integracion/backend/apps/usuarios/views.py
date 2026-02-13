from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from rest_framework.permissions import AllowAny, IsAuthenticated
from django_filters.rest_framework import DjangoFilterBackend
from .models import Usuario
from .serializers import UsuarioSerializer, UsuarioDetailSerializer

class UsuarioViewSet(viewsets.ModelViewSet):
    """
    ViewSet for Usuario CRUD operations
    """
    
    queryset = Usuario.objects.select_related('afiliado').all()
    serializer_class = UsuarioSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['rol', 'is_active']
    search_fields = ['email', 'nombre', 'apellido']
    ordering_fields = ['email', 'date_joined']
    ordering = ['email']
    
    def get_serializer_class(self):
        if self.action == 'retrieve':
            return UsuarioDetailSerializer
        return UsuarioSerializer
    
    @action(detail=False, methods=['get'], permission_classes=[IsAuthenticated])
    def me(self, request):
        """Get current user profile"""
        serializer = UsuarioDetailSerializer(request.user)
        return Response(serializer.data)
    
    @action(detail=True, methods=['post'])
    def cambiar_password(self, request, pk=None):
        """Change user password"""
        user = self.get_object()
        password = request.data.get('password')
        
        if not password:
            return Response(
                {'error': 'Password es requerido'},
                status=status.HTTP_400_BAD_REQUEST
            )
        
        user.set_password(password)
        user.save()
        
        return Response({'message': 'Password actualizado exitosamente'})
    
    @action(detail=True, methods=['post'])
    def activar_desactivar(self, request, pk=None):
        """Activate or deactivate user"""
        user = self.get_object()
        user.is_active = not user.is_active
        user.save()
        
        estado = 'activado' if user.is_active else 'desactivado'
        return Response({'message': f'Usuario {estado} exitosamente'})
