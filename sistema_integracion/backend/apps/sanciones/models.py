from django.db import models
from apps.afiliados.models import Afiliado

class Reunion(models.Model):
    """Model for union meetings"""
    
    titulo = models.CharField(max_length=200, verbose_name='Título de la Reunión')
    fecha_reunion = models.DateTimeField(verbose_name='Fecha y Hora')
    lugar = models.CharField(max_length=200, verbose_name='Lugar')
    descripcion = models.TextField(blank=True, verbose_name='Descripción')
    asistencia_obligatoria = models.BooleanField(default=True, verbose_name='Asistencia Obligatoria')
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'reuniones'
        verbose_name = 'Reunión'
        verbose_name_plural = 'Reuniones'
        ordering = ['-fecha_reunion']
    
    def __str__(self):
        return f"{self.titulo} - {self.fecha_reunion.date()}"


class Asistencia(models.Model):
    """Model for meeting attendance"""
    
    ESTADO_CHOICES = [
        ('asistio', 'Asistió'),
        ('falto', 'Faltó'),
        ('justificado', 'Falta Justificada'),
    ]
    
    reunion = models.ForeignKey(
        Reunion,
        on_delete=models.CASCADE,
        related_name='asistencias',
        verbose_name='Reunión'
    )
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.CASCADE,
        related_name='asistencias',
        verbose_name='Afiliado'
    )
    estado = models.CharField(
        max_length=15,
        choices=ESTADO_CHOICES,
        verbose_name='Estado'
    )
    observaciones = models.TextField(blank=True, verbose_name='Observaciones')
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'asistencias'
        verbose_name = 'Asistencia'
        verbose_name_plural = 'Asistencias'
        unique_together = [['reunion', 'afiliado']]
    
    def __str__(self):
        return f"{self.afiliado.nombre_completo} - {self.reunion.titulo} - {self.get_estado_display()}"


class Sancion(models.Model):
    """Model for sanctions"""
    
    ESTADO_CHOICES = [
        ('pendiente', 'Pendiente'),
        ('pagado', 'Pagado'),
        ('condonado', 'Condonado'),
    ]
    
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.CASCADE,
        related_name='sanciones',
        verbose_name='Afiliado'
    )
    asistencia = models.ForeignKey(
        Asistencia,
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name='sanciones',
        verbose_name='Asistencia Relacionada'
    )
    motivo = models.TextField(verbose_name='Motivo')
    monto = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto de la Sanción')
    fecha_sancion = models.DateField(verbose_name='Fecha de Sanción')
    fecha_limite_pago = models.DateField(null=True, blank=True, verbose_name='Fecha Límite de Pago')
    estado = models.CharField(
        max_length=15,
        choices=ESTADO_CHOICES,
        default='pendiente',
        verbose_name='Estado'
    )
    fecha_pago = models.DateField(null=True, blank=True, verbose_name='Fecha de Pago')
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'sanciones'
        verbose_name = 'Sanción'
        verbose_name_plural = 'Sanciones'
        ordering = ['-fecha_sancion']
    
    def __str__(self):
        return f"Sanción - {self.afiliado.nombre_completo} - Bs. {self.monto} ({self.get_estado_display()})"
