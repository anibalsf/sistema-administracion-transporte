from django.db import models
from apps.afiliados.models import Afiliado

class Vehiculo(models.Model):
    """Model for vehicles"""
    
    TIPO_CHOICES = [
        ('ipsum', 'Ipsum'),
        ('minibus', 'Minibús'),
    ]
    
    ESTADO_CHOICES = [
        ('activo', 'Activo'),
        ('inactivo', 'Inactivo'),
        ('mantenimiento', 'En Mantenimiento'),
    ]
    
    placa = models.CharField(
        max_length=15,
        unique=True,
        verbose_name='Placa'
    )
    marca = models.CharField(max_length=50, verbose_name='Marca')
    modelo = models.CharField(max_length=50, verbose_name='Modelo', blank=True)
    tipo = models.CharField(
        max_length=15,
        choices=TIPO_CHOICES,
        verbose_name='Tipo de Vehículo'
    )
    color = models.CharField(max_length=30, verbose_name='Color')
    anio = models.IntegerField(verbose_name='Año')
    estado = models.CharField(
        max_length=15,
        choices=ESTADO_CHOICES,
        default='activo',
        verbose_name='Estado'
    )
    capacidad = models.IntegerField(default=14, verbose_name='Capacidad de Pasajeros')
    
    # Relación con Afiliado
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.CASCADE,
        related_name='vehiculos',
        verbose_name='Propietario'
    )
    
    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'vehiculos'
        verbose_name = 'Vehículo'
        verbose_name_plural = 'Vehículos'
        ordering = ['placa']
    
    def __str__(self):
        return f"{self.placa} - {self.marca} ({self.tipo})"
