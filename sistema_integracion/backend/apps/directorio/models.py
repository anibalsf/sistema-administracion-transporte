from django.db import models
from apps.afiliados.models import Afiliado

class Directorio(models.Model):
    """Model for union board members"""
    
    CARGO_CHOICES = [
        ('secretario_general', 'Secretario General'),
        ('secretario_relaciones', 'Secretario de Relaciones'),
        ('secretario_hacienda', 'Secretario de Hacienda'),
        ('secretario_actas', 'Secretario de Actas'),
        ('secretario_conflictos', 'Secretario de Conflictos'),
        ('secretario_deportes', 'Secretario de Deportes y Vocal'),
    ]
    
    ESTADO_CHOICES = [
        ('vigente', 'Vigente'),
        ('finalizado', 'Finalizado'),
    ]
    
    afiliado = models.ForeignKey(
        Afiliado,
        on_delete=models.CASCADE,
        related_name='cargos_directorio',
        verbose_name='Afiliado'
    )
    cargo = models.CharField(
        max_length=30,
        choices=CARGO_CHOICES,
        verbose_name='Cargo'
    )
    gestion_inicio = models.DateField(verbose_name='Inicio de Gestión')
    gestion_fin = models.DateField(verbose_name='Fin de Gestión')
    estado = models.CharField(
        max_length=15,
        choices=ESTADO_CHOICES,
        default='vigente',
        verbose_name='Estado'
    )
    
    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'directorio'
        verbose_name = 'Miembro del Directorio'
        verbose_name_plural = 'Directorio'
        ordering = ['-gestion_inicio']
        unique_together = [['cargo', 'gestion_inicio']]
    
    def __str__(self):
        return f"{self.get_cargo_display()} - {self.afiliado.nombre_completo} ({self.gestion_inicio.year})"
