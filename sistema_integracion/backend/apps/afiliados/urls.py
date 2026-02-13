from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import AfiliadoViewSet

router = DefaultRouter()
router.register(r'afiliados', AfiliadoViewSet, basename='afiliado')

urlpatterns = [
    path('', include(router.urls)),
]
