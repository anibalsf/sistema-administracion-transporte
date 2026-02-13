from django.db import models
from apps.afiliados.models import Afiliado

class TipoPago(models.Model):
    """Model for payment types"""
    
    CATEGORIA_CHOICES = [
        ('cuota', 'Cuota'),
        ('aporte', 'Aporte Especial'),
        ('sancion', 'Sanción'),
        ('otro', 'Otro'),
    ]
    
    nombre = models.CharField(max_length=100, verbose_name='Nombre del Tipo de Pago')
    categoria = models.CharField(
        max_length=15,
        choices=CATEGORIA_CHOICES,
        verbose_name='Categoría'
    )
    monto_base = models.DecimalField(
        max_digits=10,
        decimal_places=2,
        verbose_name='Monto Base',
        help_text='Monto sugerido o estándar'
    )
    descripcion = models.TextField(blank=True, verbose_name='Descripción')
    activo = models.BooleanField(default=True, verbose_name='Activo')
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'tipos_pago'
        verbose_name = 'Tipo de Pago'
        verbose_name_plural = 'Tipos de Pago'
        ordering = ['categoria', 'nombre']
    
    def __str__(self):
        return f"{self.nombre} - Bs. {self.monto_base}"


class Pago(models.Model):
    """Model for affiliate payments"""
    
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.PROTECT,
        related_name='pagos',
        verbose_name='Afiliado'
    )
    tipo_pago = models.ForeignKey(
        TipoPago,
        on_delete=models.PROTECT,
        related_name='pagos',
        verbose_name='Tipo de Pago'
    )
    monto = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto')
    fecha_pago = models.DateTimeField(verbose_name='Fecha de Pago')
    mes_correspondiente = models.DateField(
        null=True,
        blank=True,
        verbose_name='Mes Correspondiente',
        help_text='Para cuotas mensuales'
    )
    descripcion = models.TextField(blank=True, verbose_name='Descripción')
    numero_recibo = models.CharField(max_length=50, unique=True, verbose_name='Número de Recibo')
    codigo_qr = models.CharField(max_length=100, blank=True, verbose_name='Código QR')
    
    # Mora calculation
    es_mora = models.BooleanField(default=False, verbose_name='Es Pago con Mora')
    monto_mora = models.DecimalField(
        max_digits=10,
        decimal_places=2,
        default=0,
        verbose_name='Monto de Mora'
    )
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'pagos'
        verbose_name = 'Pago'
        verbose_name_plural = 'Pagos'
        ordering = ['-fecha_pago']
    
    def __str__(self):
        return f"Recibo {self.numero_recibo} - {self.afiliado.nombre_completo} - Bs. {self.monto}"
    
    @property
    def total_pago(self):
        return self.monto + self.monto_mora


class Egreso(models.Model):
    """Model for expenses"""
    
    concepto = models.CharField(max_length=200, verbose_name='Concepto')
    monto = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto')
    fecha_egreso = models.DateTimeField(verbose_name='Fecha de Egreso')
    responsable = models.CharField(max_length=100, verbose_name='Responsable')
    descripcion = models.TextField(blank=True, verbose_name='Descripción Detallada')
    comprobante = models.CharField(max_length=100, blank=True, verbose_name='N° Comprobante')
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'egresos'
        verbose_name = 'Egreso'
        verbose_name_plural = 'Egresos'
        ordering = ['-fecha_egreso']
    
    def __str__(self):
        return f"{self.concepto} - Bs. {self.monto} ({self.fecha_egreso.date()})"
