from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import TipoPagoViewSet, PagoViewSet, EgresoViewSet

router = DefaultRouter()
router.register(r'tipos-pago', TipoPagoViewSet, basename='tipopago')
router.register(r'pagos', PagoViewSet, basename='pago')
router.register(r'egresos', EgresoViewSet, basename='egreso')

urlpatterns = [
    path('', include(router.urls)),
]
