from django.db import models

class Ruta(models.Model):
    """Model for routes"""
    
    nombre_ruta = models.CharField(max_length=100, unique=True, verbose_name='Nombre de Ruta')
    precio = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Precio')
    descripcion = models.TextField(blank=True, verbose_name='Descripción')
    activa = models.BooleanField(default=True, verbose_name='Ruta Activa')
    
    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'rutas'
        verbose_name = 'Ruta'
        verbose_name_plural = 'Rutas'
        ordering = ['nombre_ruta']
    
    def __str__(self):
        return f"{self.nombre_ruta} - Bs. {self.precio}"
