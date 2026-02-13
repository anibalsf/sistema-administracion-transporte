from django.db import models
from django.core.validators import RegexValidator

class Afiliado(models.Model):
    """Model for union members/affiliates"""
    
    ESTADO_CHOICES = [
        ('activo', 'Activo'),
        ('pasivo', 'Pasivo'),
        ('sancionado', 'Sancionado'),
    ]
    
    nombre = models.CharField(max_length=100, verbose_name='Nombre')
    apellido = models.CharField(max_length=100, verbose_name='Apellido')
    cedula = models.CharField(
        max_length=20,
        unique=True,
        verbose_name='Cédula de Identidad',
        validators=[RegexValidator(r'^\d{7,10}(-\d{1,2})?$', message='Formato de CI no válido')]
    )
    telefono = models.CharField(max_length=20, verbose_name='Teléfono')
    direccion = models.TextField(verbose_name='Dirección')
    fecha_ingreso = models.DateField(verbose_name='Fecha de Ingreso')
    estado = models.CharField(
        max_length=15,
        choices=ESTADO_CHOICES,
        default='activo',
        verbose_name='Estado'
    )
    foto = models.ImageField(upload_to='afiliados/', blank=True, null=True, verbose_name='Fotografía')
    
    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'afiliados'
        verbose_name = 'Afiliado'
        verbose_name_plural = 'Afiliados'
        ordering = ['apellido', 'nombre']
    
    def __str__(self):
        return f"{self.apellido}, {self.nombre} - CI: {self.cedula}"
    
    @property
    def nombre_completo(self):
        return f"{self.nombre} {self.apellido}"
