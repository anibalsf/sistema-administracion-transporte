from django.db import models
from apps.afiliados.models import Afiliado
from apps.vehiculos.models import Vehiculo
from apps.rutas.models import Ruta

class Reserva(models.Model):
    """Model for passenger reservations"""
    
    ESTADO_CHOICES = [
        ('confirmada', 'Confirmada'),
        ('cancelada', 'Cancelada'),
        ('completada', 'Completada'),
    ]
    
    vehiculo = models.ForeignKey(
        Vehiculo,
        on_delete=models.PROTECT,
        related_name='reservas',
        verbose_name='Vehículo'
    )
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.PROTECT,
        related_name='reservas',
        verbose_name='Chofer/Afiliado'
    )
    ruta = models.ForeignKey(
        Ruta,
        on_delete=models.PROTECT,
        related_name='reservas',
        verbose_name='Ruta'
    )
    
    # Passenger data
    pasajero_nombre = models.CharField(max_length=200, verbose_name='Nombre del Pasajero')
    pasajero_telefono = models.CharField(max_length=20, blank=True, verbose_name='Teléfono del Pasajero')
    pasajero_ci = models.CharField(max_length=20, blank=True, verbose_name='CI del Pasajero')
    
    # Trip details
    asiento_numero = models.IntegerField(verbose_name='Número de Asiento')
    fecha_viaje = models.DateTimeField(verbose_name='Fecha y Hora de Viaje')
    monto = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto del Pasaje')
    
    # Status
    estado = models.CharField(
        max_length=15,
        choices=ESTADO_CHOICES,
        default='confirmada',
        verbose_name='Estado'
    )
    
    observaciones = models.TextField(blank=True, verbose_name='Observaciones')
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'reservas'
        verbose_name = 'Reserva'
        verbose_name_plural = 'Reservas'
        ordering = ['-fecha_viaje']
        unique_together = [['vehiculo', 'fecha_viaje', 'asiento_numero']]
    
    def __str__(self):
        return f"Reserva {self.id} - {self.pasajero_nombre} - {self.ruta.nombre_ruta} ({self.fecha_viaje.date()})"
