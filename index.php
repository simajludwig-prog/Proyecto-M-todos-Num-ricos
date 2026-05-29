<?php

session_start();
$metodo_activo = $_GET['metodo'] ?? 'biseccion';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos Numéricos 2026 | Proyecto Final</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.8.0/math.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-2.24.1.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb; --primary-dark: #1e40af; --success: #10b981;
            --warning: #f59e0b; --danger: #ef4444; --bg: #f1f5f9;
            --card: #ffffff; --text: #0f172a; --text-light: #64748b;
            --border: #cbd5e1; --radius: 12px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: var(--bg); color: var(--text); line-height: 1.6; }
        
        /* HEADER */
        .header { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 2rem 1rem; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header h1 { font-size: 2rem; margin-bottom: 0.5rem; }
        .header p { opacity: 0.9; font-size: 1.1rem; }
        
        /* NAV */
        .nav-metodos { background: white; padding: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; }
        .nav-btn { padding: 0.75rem 1.5rem; border: 2px solid var(--primary); background: white; color: var(--primary); border-radius: 50px; cursor: pointer; font-weight: 600; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .nav-btn:hover, .nav-btn.active { background: var(--primary); color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        
        /* MAIN */
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .section { display: none; animation: fadeIn 0.5s; }
        .section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* CARDS */
        .card { background: var(--card); border-radius: var(--radius); padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border); }
        .card h2 { color: var(--primary-dark); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem; font-size: 1.5rem; }
        .card h3 { color: var(--primary); margin: 1.5rem 0 0.75rem; font-size: 1.2rem; }
        
        /* THEORY BOX */
        .theory-box { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-left: 5px solid var(--primary); padding: 1.5rem; border-radius: 0 var(--radius) var(--radius) 0; margin: 1rem 0; }
        .formula { background: white; padding: 1rem; border-radius: 8px; border: 2px solid var(--border); margin: 1rem 0; text-align: center; font-size: 1.1rem; overflow-x: auto; }
        
        /* FORM */
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin: 1.5rem 0; }
        .form-group { display: flex; flex-direction: column; }
        label { font-weight: 600; margin-bottom: 0.5rem; color: var(--text); }
        input, select { padding: 0.75rem; border: 2px solid var(--border); border-radius: 8px; font-size: 1rem; transition: all 0.3s; }
        input:focus, select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        
        .btn { background: var(--primary); color: white; border: none; padding: 1rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 1rem; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn-secondary { background: var(--text-light); }
        .btn-secondary:hover { background: var(--text); }
        
        /* TABLE */
        .table-container { overflow-x: auto; margin: 1.5rem 0; border-radius: 8px; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 1rem; text-align: center; border-bottom: 1px solid var(--border); }
        th { background: var(--primary); color: white; font-weight: 600; position: sticky; top: 0; }
        tr { transition: background 0.2s; }
        tr:hover { background: #f8fafc; }
        tr.anim-row { animation: slideIn 0.4s ease-out both; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        
        /* STEP BY STEP */
        .step-box { background: #f8fafc; border: 2px solid var(--border); border-radius: 8px; padding: 1.5rem; margin: 1rem 0; transition: all 0.3s; }
        .step-box:hover { border-color: var(--primary); transform: translateX(5px); }
        .step-number { display: inline-block; background: var(--primary); color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 0.5rem; }
        .math-result { color: var(--success); font-weight: bold; font-size: 1.1rem; }
        .math-calc { color: var(--primary); font-weight: 600; }
        
        /* GRAPHS */
        .graphs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem; margin: 2rem 0; }
        .graph-container { background: white; border-radius: var(--radius); padding: 1rem; border: 1px solid var(--border); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .graph-title { text-align: center; font-weight: 600; margin-bottom: 1rem; color: var(--text); }
        
        /* STATUS */
        .status { padding: 1rem; border-radius: 8px; margin: 1rem 0; display: none; animation: slideDown 0.3s; }
        .status.show { display: block; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .status.success { background: #d1fae5; color: #065f46; border: 2px solid var(--success); }
        .status.error { background: #fee2e2; color: #991b1b; border: 2px solid var(--danger); }
        .status.warning { background: #fef3c7; color: #92400e; border: 2px solid var(--warning); }
        
        /* FOOTER */
        footer { background: var(--text); color: white; text-align: center; padding: 2rem; margin-top: 3rem; }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header h1 { font-size: 1.5rem; }
            .graphs-grid { grid-template-columns: 1fr; }
            .card { padding: 1rem; }
            .nav-container { flex-direction: column; }
            .nav-btn { width: 100%; justify-content: center; }
        }
        
        /* PRINT */
        @media print {
            .nav-metodos, .btn, footer { display: none; }
            .section { display: block !important; page-break-inside: avoid; }
            .card { break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="header">
    <h1><i class="fas fa-calculator"></i> Métodos Numéricos</h1>
    <p>ING. JUAN CARLOS OVANDO BORRAYO</p>
    <p>Proyecto Final </p>
    <b>Integrantes</b>
    <p>Lester Abimael Jeréz Marroquin - 1990-24-3470</p>
    <p>Ludwig Joalber Simaj Caná - 1990-24-2135</p>
</div>

<nav class="nav-metodos">
    <div class="nav-container">
        <a href="?metodo=biseccion" class="nav-btn <?= $metodo_activo==='biseccion'?'active':'' ?>">
            <i class="fas fa-divide"></i> Bisección
        </a>
        <a href="?metodo=newton" class="nav-btn <?= $metodo_activo==='newton'?'active':'' ?>">
            <i class="fas fa-chart-line"></i> Newton-Raphson
        </a>
    </div>
</nav>

<div class="container">

    <!-- ==================== BISECCIÓN ==================== -->
    <div id="biseccion" class="section <?= $metodo_activo==='biseccion'?'active':'' ?>">
        
        <!-- TEORÍA -->
        <div class="card">
            <h2><i class="fas fa-book-open"></i> 1. Definición y Fundamento Teórico</h2>
            <div class="theory-box">
                <h3>📚 Definición</h3>
                <p>El <strong>Método de Bisección</strong> es un algoritmo de búsqueda de raíces que se aplica a cualquier función continua que cambie de signo en un intervalo cerrado \([a, b]\). Se basa en el <strong>Teorema del Valor Intermedio de Bolzano</strong>.</p>
                
                <h3>🎯 Fundamento Matemático</h3>
                <p>Si \(f(x)\) es continua en \([a, b]\) y \(f(a) \cdot f(b) < 0\), entonces existe al menos un número \(c \in (a, b)\) tal que \(f(c) = 0\).</p>
                
                <div class="formula">
                    \[ c_k = \frac{a_k + b_k}{2} \]
                    \[ \text{Error: } E_k = \frac{|b_k - a_k|}{2} \]
                </div>
                
                <h3>📋 Algoritmo Paso a Paso</h3>
                <ol style="margin-left: 1.5rem; line-height: 2;">
                    <li>Seleccionar intervalo inicial \([a, b]\) donde \(f(a) \cdot f(b) < 0\)</li>
                    <li>Calcular punto medio: \(c = \frac{a + b}{2}\)</li>
                    <li>Evaluar \(f(c)\)</li>
                    <li>Si \(f(a) \cdot f(c) < 0\), entonces \(b = c\); si no, \(a = c\)</li>
                    <li>Calcular error: \(E = \frac{|b - a|}{2}\)</li>
                    <li>Repetir hasta que \(E < \varepsilon\) o \(|f(c)| < \varepsilon\)</li>
                </ol>
                
                <h3>⚡ Características</h3>
                <ul style="margin-left: 1.5rem;">
                    <li><strong>Convergencia:</strong> Lineal (\(O(2^{-k})\)) - Siempre converge</li>
                    <li><strong>Velocidad:</strong> Lenta pero segura</li>
                    <li><strong>Requisitos:</strong> Función continua y cambio de signo</li>
                </ul>
            </div>
        </div>

        <!-- REPRESENTACIÓN GRÁFICA DEL MÉTODO -->
        <div class="card">
            <h2><i class="fas fa-project-diagram"></i> 2. Representación Gráfica del Método</h2>
            <p>El método de bisección divide repetidamente el intervalo a la mitad, descartando la mitad donde no hay cambio de signo:</p>
            <div id="grafica-explicativa-biseccion" style="height: 400px; margin: 1rem 0;"></div>
            <div class="theory-box" style="margin-top: 1rem;">
                <strong>Explicación:</strong> En cada iteración, el intervalo \([a,b]\) se reduce a la mitad. La raíz verdadera está siempre contenida en el nuevo intervalo más pequeño.
            </div>
        </div>

        <!-- CALCULADORA -->
        <div class="card">
            <h2><i class="fas fa-calculator"></i> 3. Calculadora Interactiva</h2>
            <div id="status-biseccion" class="status"></div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Función f(x)</label>
                    <input type="text" id="func-bis" value="x^3 - 2*x - 5" placeholder="Ej: x^3 - 2*x - 5">
                </div>
                <div class="form-group">
                    <label>Extremo a</label>
                    <input type="number" id="a-bis" value="2" step="any">
                </div>
                <div class="form-group">
                    <label>Extremo b</label>
                    <input type="number" id="b-bis" value="3" step="any">
                </div>
                <div class="form-group">
                    <label>Tolerancia ε</label>
                    <input type="number" id="tol-bis" value="0.0001" step="any" min="0">
                </div>
                <div class="form-group">
                    <label>Máx. Iteraciones</label>
                    <input type="number" id="maxiter-bis" value="50" min="1">
                </div>
            </div>
            
            <button class="btn" onclick="calcularBiseccion()">
                <i class="fas fa-play"></i> Resolver por Bisección
            </button>
            <button class="btn btn-secondary" onclick="limpiarBiseccion()" style="margin-left: 0.5rem;">
                <i class="fas fa-eraser"></i> Limpiar
            </button>
        </div>

        <!-- RESULTADOS -->
        <div id="resultados-biseccion" style="display: none;">
            
            <!-- 📋 TABLA DE RESULTADOS FINALES - BISECCIÓN -->
            <div class="card">
                <h2><i class="fas fa-clipboard-check"></i> 📋 Resultados</h2>
                <div class="table-container">
                    <table id="tabla-resultados-biseccion">
                        <thead>
                            <tr>
                                <th>Método</th>
                                <th>Función</th>
                                <th>Raíz Encontrada</th>
                                <th>f(Raíz)</th>
                                <th>Error Final</th>
                                <th>Iteraciones</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llena dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h2><i class="fas fa-list-ol"></i> 4. Procedimiento Paso a Paso</h2>
                <div id="paso-a-paso-biseccion"></div>
            </div>

            <div class="card">
                <h2><i class="fas fa-table"></i> Tabla de Iteraciones</h2>
                <div class="table-container">
                    <table id="tabla-biseccion">
                        <thead>
                            <tr>
                                <th>k</th><th>a</th><th>b</th><th>c = (a+b)/2</th>
                                <th>f(c)</th><th>Error</th><th>Decisión</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-biseccion"></tbody>
                    </table>
                </div>
            </div>

            <div class="graphs-grid">
                <div class="graph-container">
                    <div class="graph-title">Función y Raíz Encontrada</div>
                    <div id="grafica-funcion-bis" style="height: 350px;"></div>
                </div>
                <div class="graph-container">
                    <div class="graph-title">Convergencia del Error</div>
                    <div id="grafica-error-bis" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== NEWTON-RAPHSON ==================== -->
    <div id="newton" class="section <?= $metodo_activo==='newton'?'active':'' ?>">
        
        <!-- TEORÍA -->
        <div class="card">
            <h2><i class="fas fa-book-open"></i> 1. Definición y Fundamento Teórico</h2>
            <div class="theory-box">
                <h3>📚 Definición</h3>
                <p>El <strong>Método de Newton-Raphson</strong> es un algoritmo iterativo para encontrar aproximaciones de las raíces de una función real diferenciable. Utiliza la <strong>recta tangente</strong> a la curva en cada punto para aproximar la raíz.</p>
                
                <h3>🎯 Fundamento Matemático</h3>
                <p>Se basa en la expansión de Taylor de primer orden. La recta tangente en \((x_k, f(x_k))\) intersecta el eje x en:</p>
                
                <div class="formula">
                    \[ x_{k+1} = x_k - \frac{f(x_k)}{f'(x_k)} \]
                    \[ \text{Error: } E_k = |x_{k+1} - x_k| \]
                </div>
                
                <h3>📋 Algoritmo Paso a Paso</h3>
                <ol style="margin-left: 1.5rem; line-height: 2;">
                    <li>Seleccionar valor inicial \(x_0\) cercano a la raíz</li>
                    <li>Calcular \(f(x_k)\) y \(f'(x_k)\)</li>
                    <li>Aplicar fórmula: \(x_{k+1} = x_k - \frac{f(x_k)}{f'(x_k)}\)</li>
                    <li>Calcular error: \(E_k = |x_{k+1} - x_k|\)</li>
                    <li>Repetir hasta que \(E_k < \varepsilon\) o \(|f(x_k)| < \varepsilon\)</li>
                </ol>
                
                <h3>⚡ Características</h3>
                <ul style="margin-left: 1.5rem;">
                    <li><strong>Convergencia:</strong> Cuadrática (\(O(|e_k|^2)\)) - Muy rápida cerca de la raíz</li>
                    <li><strong>Velocidad:</strong> Extremadamente rápida (2-5 iteraciones típicas)</li>
                    <li><strong>Requisitos:</strong> Función diferenciable, \(f'(x) \neq 0\), buen \(x_0\)</li>
                    <li><strong>Riesgo:</strong> Puede divergir si \(x_0\) está lejos o \(f'(x) \approx 0\)</li>
                </ul>
            </div>
        </div>

        <!-- REPRESENTACIÓN GRÁFICA DEL MÉTODO -->
        <div class="card">
            <h2><i class="fas fa-project-diagram"></i> 2. Representación Gráfica del Método</h2>
            <p>Newton-Raphson usa la tangente a la curva para encontrar la siguiente aproximación:</p>
            <div id="grafica-explicativa-newton" style="height: 400px; margin: 1rem 0;"></div>
            <div class="theory-box" style="margin-top: 1rem;">
                <strong>Explicación:</strong> Desde \(x_k\), se traza la tangente a \(f(x)\). La intersección con el eje x da \(x_{k+1}\). Este proceso se repite hasta converger a la raíz.
            </div>
        </div>

        <!-- CALCULADORA -->
        <div class="card">
            <h2><i class="fas fa-calculator"></i> 3. Calculadora Interactiva</h2>
            <div id="status-newton" class="status"></div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Función f(x)</label>
                    <input type="text" id="func-new" value="x^3 - 2*x - 5" placeholder="Ej: x^3 - 2*x - 5">
                </div>
                <div class="form-group">
                    <label>Valor inicial x₀</label>
                    <input type="number" id="x0-new" value="2.5" step="any">
                </div>
                <div class="form-group">
                    <label>Tolerancia ε</label>
                    <input type="number" id="tol-new" value="0.0001" step="any" min="0">
                </div>
                <div class="form-group">
                    <label>Máx. Iteraciones</label>
                    <input type="number" id="maxiter-new" value="50" min="1">
                </div>
            </div>
            
            <button class="btn" onclick="calcularNewton()">
                <i class="fas fa-play"></i> Resolver por Newton-Raphson
            </button>
            <button class="btn btn-secondary" onclick="limpiarNewton()" style="margin-left: 0.5rem;">
                <i class="fas fa-eraser"></i> Limpiar
            </button>
        </div>

        <!-- RESULTADOS -->
        <div id="resultados-newton" style="display: none;">
            
            <!-- 📋 TABLA DE RESULTADOS FINALES - NEWTON -->
            <div class="card">
                <h2><i class="fas fa-clipboard-check"></i> 📋 Resultados</h2>
                <div class="table-container">
                    <table id="tabla-resultados-newton">
                        <thead>
                            <tr>
                                <th>Método</th>
                                <th>Función</th>
                                <th>Raíz Encontrada</th>
                                <th>f(Raíz)</th>
                                <th>Error Final</th>
                                <th>Iteraciones</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llena dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h2><i class="fas fa-list-ol"></i> 4. Procedimiento Paso a Paso</h2>
                <div id="paso-a-paso-newton"></div>
            </div>

            <div class="card">
                <h2><i class="fas fa-table"></i> Tabla de Iteraciones</h2>
                <div class="table-container">
                    <table id="tabla-newton">
                        <thead>
                            <tr>
                                <th>k</th><th>xₖ</th><th>f(xₖ)</th><th>f'(xₖ)</th>
                                <th>xₖ₊₁</th><th>Error</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-newton"></tbody>
                    </table>
                </div>
            </div>

            <div class="graphs-grid">
                <div class="graph-container">
                    <div class="graph-title">Función y Raíz Encontrada</div>
                    <div id="grafica-funcion-new" style="height: 350px;"></div>
                </div>
                <div class="graph-container">
                    <div class="graph-title">Convergencia del Error</div>
                    <div id="grafica-error-new" style="height: 350px;"></div>
                </div>
                <div class="graph-container" style="grid-column: 1 / -1;">
                    <div class="graph-title">Proceso de Aproximación (Tangentes)</div>
                    <div id="grafica-tangentes-new" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<footer>
    <p><i class="fas fa-graduation-cap"></i> Proyecto Final - Métodos Numéricos 2026</p>
   
</footer>

<script>
// ==================== FUNCIONES GENERALES ====================
function evaluarFuncion(expr, x) {
    try {
        let e = expr
            .trim()
            .replace(/,/g, '.')
            .replace(/\s+/g, '');
        return math.evaluate(e, {
            x: x,
            pi: Math.PI,
            e: Math.E
        });
    } catch (err) {
        throw new Error(
            'Error en la función. Usa ejemplos como: x^3-2*x-5 , x^2-4 , sin(x) , cos(x) , log(x)'
        );
    }
}

function derivadaNumerica(expr, x, h = 1e-6) {
    return (evaluarFuncion(expr, x + h) - evaluarFuncion(expr, x - h)) / (2 * h);
}

function mostrarStatus(id, mensaje, tipo) {
    const el = document.getElementById(id);
    el.className = `status ${tipo} show`;
    el.innerHTML = mensaje;
    setTimeout(() => el.classList.remove('show'), 8000);
}

// ==================== BISECCIÓN ====================
function calcularBiseccion() {
    const expr = document.getElementById('func-bis').value.trim();
    let a = parseFloat(document.getElementById('a-bis').value);
    let b = parseFloat(document.getElementById('b-bis').value);
    const tol = parseFloat(document.getElementById('tol-bis').value);
    const maxIter = parseInt(document.getElementById('maxiter-bis').value);

    try {
        if (!expr || isNaN(a) || isNaN(b) || isNaN(tol) || isNaN(maxIter)) {
            throw new Error("Por favor complete todos los campos correctamente");
        }
        if (a >= b) throw new Error("El extremo 'a' debe ser menor que 'b'");
        
        let fa = evaluarFuncion(expr, a);
        let fb = evaluarFuncion(expr, b);
        
        if (fa * fb >= 0) {
            throw new Error(`f(a)·f(b) = ${fa.toFixed(4)}·${fb.toFixed(4)} = ${(fa*fb).toFixed(4)} ≥ 0. No hay cambio de signo en [${a}, ${b}]`);
        }

        let iteraciones = [];
        let error = 1;
        let c = a;
        let decision = '';

        for (let k = 1; k <= maxIter; k++) {
            c = (a + b) / 2;
            let fc = evaluarFuncion(expr, c);
            error = Math.abs((b - a) / 2);
            
            if (fa * fc < 0) {
                b = c;
                fb = fc;
                decision = 'b = c (raíz en [a,c])';
            } else {
                a = c;
                fa = fc;
                decision = 'a = c (raíz en [c,b])';
            }
            
            iteraciones.push({
                k, a_ant: (k===1 ? (parseFloat(document.getElementById('a-bis').value)) : iteraciones[k-2].a), 
                b_ant: (k===1 ? (parseFloat(document.getElementById('b-bis').value)) : iteraciones[k-2].b),
                a, b, c, fc, error, decision
            });
            
            if (error < tol || Math.abs(fc) < tol) break;
        }

        renderizarBiseccion(iteraciones, expr, c, error);
        mostrarStatus('status-biseccion', 
            `<i class="fas fa-check-circle"></i> <strong>¡Raíz encontrada!</strong> x = ${c.toFixed(8)} | Error: ${error.toExponential(4)} | Iteraciones: ${iteraciones.length}`, 
            'success');
            
    } catch (err) {
        mostrarStatus('status-biseccion', `<i class="fas fa-exclamation-triangle"></i> ${err.message}`, 'error');
    }
}

function renderizarBiseccion(iteraciones, expr, raiz, error) {
    // Tabla de iteraciones
    const tbody = document.getElementById('tbody-biseccion');
    tbody.innerHTML = '';
    iteraciones.forEach((it, i) => {
        const tr = document.createElement('tr');
        tr.className = 'anim-row';
        tr.style.animationDelay = `${i * 0.05}s`;
        tr.innerHTML = `
            <td>${it.k}</td>
            <td>${it.a.toFixed(6)}</td>
            <td>${it.b.toFixed(6)}</td>
            <td class="math-calc">${it.c.toFixed(6)}</td>
            <td>${it.fc.toExponential(4)}</td>
            <td class="${it.error < parseFloat(document.getElementById('tol-bis').value) ? 'math-result' : ''}">${it.error.toExponential(4)}</td>
            <td>${it.decision}</td>
        `;
        tbody.appendChild(tr);
    });

    // Paso a paso detallado
    const pasoDiv = document.getElementById('paso-a-paso-biseccion');
    pasoDiv.innerHTML = '';
    iteraciones.forEach((it, i) => {
        const div = document.createElement('div');
        div.className = 'step-box';
        div.innerHTML = `
            <div><span class="step-number">${it.k}</span><strong>Iteración ${it.k}</strong></div>
            <div style="margin-top: 0.5rem;">
                Intervalo: [${it.a_ant.toFixed(4)}, ${it.b_ant.toFixed(4)}] → f(a) = ${evaluarFuncion(expr, it.a_ant).toExponential(2)}, f(b) = ${evaluarFuncion(expr, it.b_ant).toExponential(2)}<br>
                Cálculo: c = (${it.a_ant.toFixed(4)} + ${it.b_ant.toFixed(4)})/2 = <span class="math-calc">${it.c.toFixed(6)}</span><br>
                Evaluación: f(${it.c.toFixed(4)}) = ${expr.replace(/x/g, `(${it.c.toFixed(4)})`) } = <span class="math-calc">${it.fc.toExponential(4)}</span><br>
                Error: E = |${it.b.toFixed(4)} - ${it.a.toFixed(4)}|/2 = <span class="${it.error < parseFloat(document.getElementById('tol-bis').value) ? 'math-result' : ''}">${it.error.toExponential(4)}</span><br>
                <strong>${it.decision}</strong>
            </div>
        `;
        pasoDiv.appendChild(div);
    });

    // === 📋 LLENAR TABLA DE RESULTADOS - BISECCIÓN ===
    const lastIter = iteraciones[iteraciones.length - 1];
    const raizFinal = lastIter.c;
    const fRaiz = evaluarFuncion(expr, raizFinal);
    const errorFinal = lastIter.error;
    const tolerancia = parseFloat(document.getElementById('tol-bis').value);
    const estadoBis = errorFinal < tolerancia ? 
        '<span style="color:var(--success); font-weight:600"><i class="fas fa-check"></i> Convergió</span>' : 
        '<span style="color:var(--warning); font-weight:600"><i class="fas fa-exclamation"></i> Máx. iteraciones</span>';

    const tbodyResultadosBis = document.querySelector('#tabla-resultados-biseccion tbody');
    tbodyResultadosBis.innerHTML = `
        <tr>
            <td><strong>Bisección</strong></td>
            <td><code>${expr}</code></td>
            <td class="math-result">${raizFinal.toFixed(8)}</td>
            <td>${fRaiz.toExponential(4)}</td>
            <td>${errorFinal.toExponential(4)}</td>
            <td>${iteraciones.length}</td>
            <td>${estadoBis}</td>
        </tr>
    `;

    // Gráficas
    graficarFuncionBiseccion(expr, raiz, iteraciones);
    graficarErrorBiseccion(iteraciones);
    
    document.getElementById('resultados-biseccion').style.display = 'block';
    document.getElementById('resultados-biseccion').scrollIntoView({behavior: 'smooth', block: 'start'});
    
    if (window.MathJax) MathJax.typeset();
}

function graficarFuncionBiseccion(expr, raiz, iteraciones) {
    const xMin = raiz - 2, xMax = raiz + 2;
    const step = (xMax - xMin) / 200;
    const xVals = [], yVals = [];
    
    for (let x = xMin; x <= xMax; x += step) {
        xVals.push(x);
        try { yVals.push(evaluarFuncion(expr, x)); } catch { yVals.push(null); }
    }
    
    const traceFunc = {
        x: xVals, y: yVals, mode: 'lines', name: 'f(x)',
        line: {color: '#2563eb', width: 3}
    };
    
    const traceRaiz = {
        x: [raiz, raiz], y: [Math.min(...yVals), Math.max(...yVals)],
        mode: 'lines', name: 'Raíz',
        line: {color: '#ef4444', width: 2, dash: 'dot'}
    };
    
    const tracePuntos = {
        x: iteraciones.map(it => it.c),
        y: iteraciones.map(it => it.fc),
        mode: 'markers+text', name: 'Iteraciones',
        marker: {color: '#10b981', size: 10},
        text: iteraciones.map(it => it.k),
        textposition: 'top center'
    };
    
    Plotly.newPlot('grafica-funcion-bis', [traceFunc, traceRaiz, tracePuntos], {
        title: `f(x) = ${expr}`, xaxis: {title: 'x', gridcolor: '#e2e8f0'},
        yaxis: {title: 'f(x)', gridcolor: '#e2e8f0', zeroline: true},
        hovermode: 'closest'
    }, {responsive: true});
}

function graficarErrorBiseccion(iteraciones) {
    const trace = {
        x: iteraciones.map(it => it.k),
        y: iteraciones.map(it => it.error),
        mode: 'lines+markers', name: 'Error',
        line: {color: '#f59e0b', width: 2},
        marker: {size: 6}
    };
    
    Plotly.newPlot('grafica-error-bis', [trace], {
        title: 'Convergencia del Error',
        xaxis: {title: 'Iteración k', gridcolor: '#e2e8f0'},
        yaxis: {title: 'Error', type: 'log', gridcolor: '#e2e8f0'},
        hovermode: 'closest'
    }, {responsive: true});
}

function limpiarBiseccion() {
    document.getElementById('func-bis').value = 'x^3 - 2*x - 5';
    document.getElementById('a-bis').value = '2';
    document.getElementById('b-bis').value = '3';
    document.getElementById('tol-bis').value = '0.0001';
    document.getElementById('maxiter-bis').value = '50';
    document.getElementById('resultados-biseccion').style.display = 'none';
    document.getElementById('status-biseccion').classList.remove('show');
}

// ==================== NEWTON-RAPHSON ====================
function calcularNewton() {
    const expr = document.getElementById('func-new').value.trim();
    const x0 = parseFloat(document.getElementById('x0-new').value);
    const tol = parseFloat(document.getElementById('tol-new').value);
    const maxIter = parseInt(document.getElementById('maxiter-new').value);

    try {
        if (!expr || isNaN(x0) || isNaN(tol) || isNaN(maxIter)) {
            throw new Error("Por favor complete todos los campos correctamente");
        }

        let iteraciones = [];
        let x = x0;
        let error = 1;

        for (let k = 1; k <= maxIter; k++) {
            let fx = evaluarFuncion(expr, x);
            let dfx = derivadaNumerica(expr, x);
            
            if (Math.abs(dfx) < 1e-10) {
                throw new Error(`Derivada ≈ 0 en x = ${x.toFixed(6)}. El método diverge.`);
            }
            
            let xNuevo = x - fx / dfx;
            error = Math.abs(xNuevo - x);
            
            iteraciones.push({
                k, x, xNuevo, fx, dfx, error
            });
            
            if (error < tol || Math.abs(fx) < tol) break;
            x = xNuevo;
        }

        const raiz = iteraciones[iteraciones.length - 1].xNuevo;
        renderizarNewton(iteraciones, expr, raiz, error);
        mostrarStatus('status-newton', 
            `<i class="fas fa-check-circle"></i> <strong>¡Raíz encontrada!</strong> x = ${raiz.toFixed(8)} | Error: ${error.toExponential(4)} | Iteraciones: ${iteraciones.length}`, 
            'success');
            
    } catch (err) {
        mostrarStatus('status-newton', `<i class="fas fa-exclamation-triangle"></i> ${err.message}`, 'error');
    }
}

function renderizarNewton(iteraciones, expr, raiz, error) {
    // Tabla de iteraciones
    const tbody = document.getElementById('tbody-newton');
    tbody.innerHTML = '';
    iteraciones.forEach((it, i) => {
        const tr = document.createElement('tr');
        tr.className = 'anim-row';
        tr.style.animationDelay = `${i * 0.05}s`;
        tr.innerHTML = `
            <td>${it.k}</td>
            <td>${it.x.toFixed(6)}</td>
            <td>${it.fx.toExponential(4)}</td>
            <td>${it.dfx.toExponential(4)}</td>
            <td class="math-calc">${it.xNuevo.toFixed(6)}</td>
            <td class="${it.error < parseFloat(document.getElementById('tol-new').value) ? 'math-result' : ''}">${it.error.toExponential(4)}</td>
        `;
        tbody.appendChild(tr);
    });

    // Paso a paso detallado
    const pasoDiv = document.getElementById('paso-a-paso-newton');
    pasoDiv.innerHTML = '';
    iteraciones.forEach((it, i) => {
        const div = document.createElement('div');
        div.className = 'step-box';
        div.innerHTML = `
            <div><span class="step-number">${it.k}</span><strong>Iteración ${it.k}</strong></div>
            <div style="margin-top: 0.5rem;">
                xₖ = ${it.x.toFixed(6)}<br>
                f(xₖ) = ${expr.replace(/x/g, `(${it.x.toFixed(4)})`)} = <span class="math-calc">${it.fx.toExponential(4)}</span><br>
                f'(xₖ) = ${it.dfx.toExponential(4)} (derivada numérica)<br>
                xₖ₊₁ = ${it.x.toFixed(4)} - ${it.fx.toExponential(2)}/${it.dfx.toExponential(2)} = <span class="math-calc">${it.xNuevo.toFixed(6)}</span><br>
                Error: |${it.xNuevo.toFixed(6)} - ${it.x.toFixed(4)}| = <span class="${it.error < parseFloat(document.getElementById('tol-new').value) ? 'math-result' : ''}">${it.error.toExponential(4)}</span>
            </div>
        `;
        pasoDiv.appendChild(div);
    });

    // === 📋 LLENAR TABLA DE RESULTADOS - NEWTON ===
    const lastIterNew = iteraciones[iteraciones.length - 1];
    const raizFinalNew = lastIterNew.xNuevo;
    const fRaizNew = evaluarFuncion(expr, raizFinalNew);
    const errorFinalNew = lastIterNew.error;
    const toleranciaNew = parseFloat(document.getElementById('tol-new').value);
    const estadoNew = errorFinalNew < toleranciaNew ? 
        '<span style="color:var(--success); font-weight:600"><i class="fas fa-check"></i> Convergió</span>' : 
        '<span style="color:var(--warning); font-weight:600"><i class="fas fa-exclamation"></i> Máx. iteraciones</span>';

    const tbodyResultadosNew = document.querySelector('#tabla-resultados-newton tbody');
    tbodyResultadosNew.innerHTML = `
        <tr>
            <td><strong>Newton-Raphson</strong></td>
            <td><code>${expr}</code></td>
            <td class="math-result">${raizFinalNew.toFixed(8)}</td>
            <td>${fRaizNew.toExponential(4)}</td>
            <td>${errorFinalNew.toExponential(4)}</td>
            <td>${iteraciones.length}</td>
            <td>${estadoNew}</td>
        </tr>
    `;

    // Gráficas
    graficarFuncionNewton(expr, raiz, iteraciones);
    graficarErrorNewton(iteraciones);
    graficarTangentesNewton(expr, iteraciones, raiz);
    
    document.getElementById('resultados-newton').style.display = 'block';
    document.getElementById('resultados-newton').scrollIntoView({behavior: 'smooth', block: 'start'});
    
    if (window.MathJax) MathJax.typeset();
}

function graficarFuncionNewton(expr, raiz, iteraciones) {
    const xMin = raiz - 2, xMax = raiz + 2;
    const step = (xMax - xMin) / 200;
    const xVals = [], yVals = [];
    
    for (let x = xMin; x <= xMax; x += step) {
        xVals.push(x);
        try { yVals.push(evaluarFuncion(expr, x)); } catch { yVals.push(null); }
    }
    
    const traceFunc = {
        x: xVals, y: yVals, mode: 'lines', name: 'f(x)',
        line: {color: '#2563eb', width: 3}
    };
    
    const traceRaiz = {
        x: [raiz, raiz], y: [Math.min(...yVals), Math.max(...yVals)],
        mode: 'lines', name: 'Raíz',
        line: {color: '#ef4444', width: 2, dash: 'dot'}
    };
    
    const tracePuntos = {
        x: iteraciones.map(it => it.x),
        y: iteraciones.map(it => it.fx),
        mode: 'markers+text', name: 'Iteraciones',
        marker: {color: '#10b981', size: 10},
        text: iteraciones.map(it => it.k),
        textposition: 'top center'
    };
    
    Plotly.newPlot('grafica-funcion-new', [traceFunc, traceRaiz, tracePuntos], {
        title: `f(x) = ${expr}`, xaxis: {title: 'x', gridcolor: '#e2e8f0'},
        yaxis: {title: 'f(x)', gridcolor: '#e2e8f0', zeroline: true},
        hovermode: 'closest'
    }, {responsive: true});
}

function graficarErrorNewton(iteraciones) {
    const trace = {
        x: iteraciones.map(it => it.k),
        y: iteraciones.map(it => it.error),
        mode: 'lines+markers', name: 'Error',
        line: {color: '#f59e0b', width: 2},
        marker: {size: 6}
    };
    
    Plotly.newPlot('grafica-error-new', [trace], {
        title: 'Convergencia del Error',
        xaxis: {title: 'Iteración k', gridcolor: '#e2e8f0'},
        yaxis: {title: 'Error', type: 'log', gridcolor: '#e2e8f0'},
        hovermode: 'closest'
    }, {responsive: true});
}

function graficarTangentesNewton(expr, iteraciones, raiz) {
    const xMin = raiz - 2, xMax = raiz + 2;
    const traces = [];
    
    // Función principal
    const step = (xMax - xMin) / 200;
    const xVals = [], yVals = [];
    for (let x = xMin; x <= xMax; x += step) {
        xVals.push(x);
        try { yVals.push(evaluarFuncion(expr, x)); } catch { yVals.push(null); }
    }
    traces.push({
        x: xVals, y: yVals, mode: 'lines', name: 'f(x)',
        line: {color: '#2563eb', width: 3}
    });
    
    // Tangentes
    const colors = ['#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
    iteraciones.slice(0, 5).forEach((it, i) => {
        const m = it.dfx;
        const b = it.fx - m * it.x;
        const y1 = m * xMin + b;
        const y2 = m * xMax + b;
        
        traces.push({
            x: [xMin, xMax], y: [y1, y2], mode: 'lines',
            name: `Tangente k=${it.k}`,
            line: {color: colors[i % colors.length], width: 2, dash: 'dash'}
        });
        
        // Punto de tangencia
        traces.push({
            x: [it.x], y: [it.fx], mode: 'markers',
            name: `x${it.k}`,
            marker: {color: colors[i % colors.length], size: 10}
        });
    });
    
    // Raíz
    traces.push({
        x: [raiz, raiz], y: [Math.min(...yVals), Math.max(...yVals)],
        mode: 'lines', name: 'Raíz',
        line: {color: '#ef4444', width: 2, dash: 'dot'}
    });
    
    Plotly.newPlot('grafica-tangentes-new', traces, {
        title: 'Proceso de Newton-Raphson: Tangentes',
        xaxis: {title: 'x', gridcolor: '#e2e8f0'},
        yaxis: {title: 'f(x)', gridcolor: '#e2e8f0', zeroline: true},
        hovermode: 'closest'
    }, {responsive: true});
}

function limpiarNewton() {
    document.getElementById('func-new').value = 'x^3 - 2*x - 5';
    document.getElementById('x0-new').value = '2.5';
    document.getElementById('tol-new').value = '0.0001';
    document.getElementById('maxiter-new').value = '50';
    document.getElementById('resultados-newton').style.display = 'none';
    document.getElementById('status-newton').classList.remove('show');
}

// ==================== GRÁFICAS EXPLICATIVAS INICIALES ====================
window.addEventListener('load', function() {
    // Gráfica explicativa Bisección
    const xBis = [0, 1, 2, 2.5, 3, 4, 5];
    const yBis = [-5, -2, -1, 0.5, 2, 5, 10];
    Plotly.newPlot('grafica-explicativa-biseccion', [{
        x: xBis, y: yBis, mode: 'lines+markers', name: 'f(x)',
        line: {color: '#2563eb', width: 3}, marker: {size: 8}
    }, {
        x: [2, 3, 3], y: [0, 0, 2], mode: 'lines', name: 'Iteración 1',
        line: {color: '#10b981', width: 2, dash: 'dash'}
    }, {
        x: [2.5, 2.5], y: [-1, 0.5], mode: 'markers', name: 'c₁ = 2.5',
        marker: {color: '#ef4444', size: 12}
    }], {
        title: 'Método de Bisección - Concepto Visual',
        xaxis: {title: 'x', gridcolor: '#e2e8f0'},
        yaxis: {title: 'f(x)', gridcolor: '#e2e8f0', zeroline: true},
        annotations: [
            {x: 2, y: -1, text: 'a', showarrow: true, arrowcolor: '#10b981'},
            {x: 3, y: 2, text: 'b', showarrow: true, arrowcolor: '#10b981'},
            {x: 2.5, y: 0.5, text: 'c', showarrow: true, arrowcolor: '#ef4444'}
        ]
    }, {responsive: true});
    
    // Gráfica explicativa Newton
    const xNew = [0, 1, 2, 2.5, 3, 4];
    const yNew = [5, 2, -1, -0.5, 1, 5];
    Plotly.newPlot('grafica-explicativa-newton', [{
        x: xNew, y: yNew, mode: 'lines+markers', name: 'f(x)',
        line: {color: '#2563eb', width: 3}, marker: {size: 8}
    }, {
        x: [2, 2.33], y: [-1, 0], mode: 'lines', name: 'Tangente x₀',
        line: {color: '#10b981', width: 2}
    }, {
        x: [2, 2.33], y: [-1, -1], mode: 'lines', name: 'Proyección',
        line: {color: '#f59e0b', width: 2, dash: 'dot'}
    }], {
        title: 'Método de Newton-Raphson - Concepto Visual',
        xaxis: {title: 'x', gridcolor: '#e2e8f0'},
        yaxis: {title: 'f(x)', gridcolor: '#e2e8f0', zeroline: true},
        annotations: [
            {x: 2, y: -1, text: 'x₀', showarrow: true},
            {x: 2.33, y: 0, text: 'x₁', showarrow: true, arrowcolor: '#10b981'}
        ]
    }, {responsive: true});
});
</script>

</body>
</html>