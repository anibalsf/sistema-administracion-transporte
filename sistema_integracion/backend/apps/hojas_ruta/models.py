from django.db import models
from apps.afiliados.models import Afiliado
from apps.vehiculos.models import Vehiculo
from apps.rutas.models import Ruta

class AgenteParada(models.Model):
    """Model for stop agents (designated affiliates)"""
    
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.CASCADE,
        related_name='turnos_agente',
        verbose_name='Afiliado Designado'
    )
    fecha_designacion = models.DateField(verbose_name='Fecha de Designación')
    observaciones = models.TextField(blank=True, verbose_name='Observaciones')
    
    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'agentes_parada'
        verbose_name = 'Agente de Parada'
        verbose_name_plural = 'Agentes de Parada'
        ordering = ['-fecha_designacion']
        unique_together = [['afiliado', 'fecha_designacion']]
    
    def __str__(self):
        return f"{self.afiliado.nombre_completo} - {self.fecha_designacion}"


class HojaRuta(models.Model):
    """Model for route sheets"""
    
    vehiculo = models.ForeignKey(
        Vehiculo,
        on_delete=models.PROTECT,
        related_name='hojas_ruta',
        verbose_name='Vehículo'
    )
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.PROTECT,
        related_name='hojas_ruta',
        verbose_name='Afiliado'
    )
    ruta = models.ForeignKey(
        Ruta,
        on_delete=models.PROTECT,
        related_name='hojas_ruta',
        verbose_name='Ruta'
    )
    agente_parada = models.ForeignKey(
        AgenteParada,
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name='hojas_ruta_asignadas',
        verbose_name='Agente de Parada'
    )
    
    fecha_emision = models.DateField(verbose_name='Fecha de Emisión')
    fecha_salida = models.DateTimeField(verbose_name='Fecha y Hora de Salida')
    monto = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto')
    pdf_url = models.CharField(max_length=255, blank=True, verbose_name='URL del PDF')
    codigo_qr = models.CharField(max_length=100, blank=True, verbose_name='Código QR')
    
    # Control
    enviado_whatsapp = models.BooleanField(default=False, verbose_name='Enviado por WhatsApp')
    fecha_envio_whatsapp = models.DateTimeField(null=True, blank=True, verbose_name='Fecha de Envío WhatsApp')
    
    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'hojas_ruta'
        verbose_name = 'Hoja de Ruta'
        verbose_name_plural = 'Hojas de Ruta'
        ordering = ['-fecha_emision', '-fecha_salida']
    
    def __str__(self):
        return f"HR {self.id} - {self.vehiculo.placa} - {self.ruta.nombre_ruta} ({self.fecha_emision})"
