# UNIVERSIDAD MARIANO GALVÉZ DE GUATEMALA SEDE CHIMALTENANGO

# Docente

ING. JUAN CARLOS OVANDO BORRAYO

# Curso

	Métodos Numéricos - PROYECTO FINAL

# Autores

| Nombre                         | Carné        |
| ------------------------------ | ------------ |
| Lester Abimael Jeréz Marroquín | 1990-24-3470 |
| Ludwig Joalber Simaj Caná      | 1990-24-2135 |

---

-----------------------------------------------------------------------

#Instalación e Implementación - Proyecto Métodos Numéricos 2026

## Descripción

Este proyecto es una aplicación web desarrollada en **PHP + JavaScript** que permite resolver ecuaciones utilizando los métodos numéricos:

* Método de Bisección
* Método de Newton-Raphson

El sistema incluye:

* Procedimientos paso a paso
* Tablas de iteraciones
* Gráficas dinámicas
* Cálculo de errores
* Interfaz moderna y responsiva

---

# Requisitos del Sistema

Antes de ejecutar el proyecto asegúrate de tener instalado:

## Requisitos mínimos

* PHP 7.4 o superior
* Navegador moderno
* Servidor local:

  * XAMPP
  * Laragon
  * WAMP
  * Apache

---

# Estructura del Proyecto

```bash id="c8m9a1"
metodos-numericos/
│
├── index.php
└── README.md
```

---

# Instalación del Proyecto

## Descargar el proyecto

Puedes:

* Clonar el repositorio
* Descargar el ZIP o archivos

## Descargar o copiar el repositorio Git 


##  Colocar el proyecto en el servidor local

Mover la carpeta del proyecto a:

### XAMPP


C:\xampp\htdocs\
```

### Laragon


C:\laragon\www\
```

### Linux Apache


/var/www/html/
```



#  Ejecutar el Proyecto

##  Iniciar Apache

Abrir:

* XAMPP Control Panel
* Laragon

Y activar:

* Apache

---

##  Abrir el navegador

Ingresar la URL:


http://localhost/metodos-numericos/
```

---

#  Librerías Utilizadas

El sistema usa librerías CDN externas.

## Math.js

Permite evaluar funciones matemáticas.


https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.8.0/math.min.js


---

## Plotly.js

Genera las gráficas interactivas.


https://cdn.plot.ly/plotly-2.24.1.min.js




## MathJax

Renderiza fórmulas matemáticas.

https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js


---

#  Cómo Utilizar el Sistema

---

#  Método de Bisección

##  Seleccionar la pestaña “Bisección”

##  Ingresar:

* Función matemática
* Extremo a
* Extremo b
* Tolerancia
* Máximo de iteraciones

### Ejemplo


Función: x^3 - 2*x - 5
a = 2
b = 3
Tolerancia = 0.0001
```

---

## Presionar

Resolver por Bisección


---

##  El sistema mostrará

* Resultado final
* Tabla de iteraciones
* Procedimiento paso a paso
* Gráfica de la función
* Convergencia del error

---

# Método de Newton-Raphson

## Seleccionar la pestaña “Newton-Raphson”

## Ingresar:

* Función matemática
* Valor inicial x₀
* Tolerancia
* Máximo de iteraciones

### Ejemplo

```text id="w4r9t1"
Función: x^3 - 2*x - 5
x0 = 2.5
Tolerancia = 0.0001
```

---

## Presionar

```text id="y8u2i5"
Resolver por Newton-Raphson
```

---

## El sistema mostrará

* Aproximación de la raíz
* Tabla de iteraciones
* Tangentes del método
* Error por iteración
* Procedimiento detallado
* Gráficas dinámicas

---

# Funcionalidades del Sistema

## Cálculo automático

El sistema evalúa funciones automáticamente usando Math.js.

---

## Gráficas interactivas

Se generan gráficas en tiempo real utilizando Plotly.js.

---

## Visualización matemática

Las fórmulas se renderizan con MathJax.

---

## Diseño responsive

Compatible con:

* PC
* Tablets
* Celulares

---

# Personalización

## Cambiar función predeterminada

Buscar:


value="x^3 - 2*x - 5"


Y reemplazar por la función deseada.

---

## Cambiar colores del sistema

Modificar las variables CSS:

:root {
    --primary: #2563eb;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
}
```

---

# Posibles Errores

## Error: “No hay cambio de signo”

Sucede cuando:


f(a) * f(b) >= 0
```

Debe elegir otro intervalo.

---

## Error: “Derivada ≈ 0”

Sucede en Newton-Raphson cuando:


f'(x) ≈ 0
```

Debe usar otro valor inicial.

---

# Recomendaciones

* Usar funciones continuas
* Evitar derivadas cercanas a cero
* Usar intervalos válidos
* Verificar tolerancias pequeñas

---

# Características Técnicas

| Característica    | Implementación |
| ----------------- | -------------- |
| Lenguaje Backend  | PHP            |
| Lenguaje Frontend | JavaScript     |
| Estilos           | CSS3           |
| Matemática        | Math.js        |
| Gráficas          | Plotly.js      |
| Fórmulas          | MathJax        |

---


# Licencia

Proyecto desarrollado únicamente con fines educativos para el curso de Métodos Numéricos 2026.
