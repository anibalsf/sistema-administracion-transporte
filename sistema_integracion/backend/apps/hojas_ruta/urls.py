from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import HojaRutaViewSet, AgenteParadaViewSet

router = DefaultRouter()
router.register(r'hojas-ruta', HojaRutaViewSet, basename='hojaruta')
router.register(r'agentes-parada', AgenteParadaViewSet, basename='agenteparada')

urlpatterns = [
    path('', include(router.urls)),
]
