from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import ReunionViewSet, AsistenciaViewSet, SancionViewSet

router = DefaultRouter()
router.register(r'reuniones', ReunionViewSet, basename='reunion')
router.register(r'asistencias', AsistenciaViewSet, basename='asistencia')
router.register(r'sanciones', SancionViewSet, basename='sancion')

urlpatterns = [
    path('', include(router.urls)),
]
