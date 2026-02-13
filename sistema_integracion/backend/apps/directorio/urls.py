from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import DirectorioViewSet

router = DefaultRouter()
router.register(r'directorio', DirectorioViewSet, basename='directorio')

urlpatterns = [
    path('', include(router.urls)),
]
