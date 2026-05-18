<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>POA - Documentación de Endpoints</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>


    <script src="{{ asset("/vendor/scribe/js/theme-default-5.10.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-dashboard" class="tocify-header">
                <li class="tocify-item level-1" data-unique="dashboard">
                    <a href="#dashboard">Dashboard</a>
                </li>
                                    <ul id="tocify-subheader-dashboard" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="dashboard-GET-">
                                <a href="#dashboard-GET-">Mostrar dashboard principal</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTadminlte-darkmode-toggle">
                                <a href="#endpoints-POSTadminlte-darkmode-toggle">Toggle the dark mode preference.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTlivewire-88aad302-update">
                                <a href="#endpoints-POSTlivewire-88aad302-update">POST livewire-88aad302/update</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-livewire-min-js">
                                <a href="#endpoints-GETlivewire-88aad302-livewire-min-js">GET livewire-88aad302/livewire.min.js</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-livewire-min-js-map">
                                <a href="#endpoints-GETlivewire-88aad302-livewire-min-js-map">GET livewire-88aad302/livewire.min.js.map</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-livewire-csp-min-js-map">
                                <a href="#endpoints-GETlivewire-88aad302-livewire-csp-min-js-map">GET livewire-88aad302/livewire.csp.min.js.map</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTlivewire-88aad302-upload-file">
                                <a href="#endpoints-POSTlivewire-88aad302-upload-file">POST livewire-88aad302/upload-file</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-preview-file--filename-">
                                <a href="#endpoints-GETlivewire-88aad302-preview-file--filename-">GET livewire-88aad302/preview-file/{filename}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-js--component--js">
                                <a href="#endpoints-GETlivewire-88aad302-js--component--js">GET livewire-88aad302/js/{component}.js</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-css--component--css">
                                <a href="#endpoints-GETlivewire-88aad302-css--component--css">GET livewire-88aad302/css/{component}.css</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETlivewire-88aad302-css--component--global-css">
                                <a href="#endpoints-GETlivewire-88aad302-css--component--global-css">GET livewire-88aad302/css/{component}.global.css</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETup">
                                <a href="#endpoints-GETup">GET up</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETstorage--path-">
                                <a href="#endpoints-GETstorage--path-">GET storage/{path}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTstorage--path-">
                                <a href="#endpoints-PUTstorage--path-">PUT storage/{path}</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-estado-de-resultados" class="tocify-header">
                <li class="tocify-item level-1" data-unique="estado-de-resultados">
                    <a href="#estado-de-resultados">Estado de Resultados</a>
                </li>
                                    <ul id="tocify-subheader-estado-de-resultados" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="estado-de-resultados-GETestado-resultados">
                                <a href="#estado-de-resultados-GETestado-resultados">Mostrar Estado de Resultados</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="estado-de-resultados-GETestado-resultados-export">
                                <a href="#estado-de-resultados-GETestado-resultados-export">Exportar Estado de Resultados (Excel)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="estado-de-resultados-POSTestado-resultados-store">
                                <a href="#estado-de-resultados-POSTestado-resultados-store">Guardar registro ER manual</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="estado-de-resultados-POSTestado-resultados-import-pdf">
                                <a href="#estado-de-resultados-POSTestado-resultados-import-pdf">Importar Estado de Resultados desde PDF</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-importaciones" class="tocify-header">
                <li class="tocify-item level-1" data-unique="importaciones">
                    <a href="#importaciones">Importaciones</a>
                </li>
                                    <ul id="tocify-subheader-importaciones" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="importaciones-GETimportaciones">
                                <a href="#importaciones-GETimportaciones">Mostrar centro de importación</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-er">
                                <a href="#importaciones-POSTimportaciones-er">Importar Estado de Resultados (Excel)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-ventas">
                                <a href="#importaciones-POSTimportaciones-ventas">Importar ventas detalladas (Excel)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-pdf-realizado">
                                <a href="#importaciones-POSTimportaciones-pdf-realizado">Importar realizado desde PDF</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-surtimiento">
                                <a href="#importaciones-POSTimportaciones-surtimiento">Importar surtimiento a tiendas (Excel)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-mermas">
                                <a href="#importaciones-POSTimportaciones-mermas">Importar mermas y quebrantos (Excel)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-mermas-comprometido">
                                <a href="#importaciones-POSTimportaciones-mermas-comprometido">Guardar mermas realizadas (formulario manual)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="importaciones-POSTimportaciones-apertura-tiendas">
                                <a href="#importaciones-POSTimportaciones-apertura-tiendas">Importar apertura de tiendas (Excel)</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-poa" class="tocify-header">
                <li class="tocify-item level-1" data-unique="poa">
                    <a href="#poa">POA</a>
                </li>
                                    <ul id="tocify-subheader-poa" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="poa-GETpoa">
                                <a href="#poa-GETpoa">Mostrar POA</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="poa-GETpoa-export">
                                <a href="#poa-GETpoa-export">Exportar POA (Excel/PDF)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="poa-POSTpoa-nota">
                                <a href="#poa-POSTpoa-nota">Guardar nota aclaratoria</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: May 18, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Sistema de Programación Anual de Trabajo (POA) y Estado de Resultados. Documentación interna para el equipo de desarrollo.</p>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>Documentación de los endpoints del módulo POA.

&gt; Esta documentación es **exclusiva para el equipo de desarrollo**.</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="dashboard">Dashboard</h1>

    

                                <h2 id="dashboard-GET-">Mostrar dashboard principal</h2>

<p>
</p>

<p>Renderiza el dashboard con indicadores de eficiencia por almacén:
índice consolidado, top/bottom 3 almacenes, semáforo de rendimiento.
Calcula el % de logro por concepto vs meta para cada almacén.</p>

<span id="example-requests-GET-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GET-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=utf-8
cache-control: no-cache, private
set-cookie: XSRF-TOKEN=eyJpdiI6ImZqK3VtNFdQY3d3b1dkUDlYZDRXUFE9PSIsInZhbHVlIjoiMjRkMFV3alpGU2xyVVF3SzJiOERUWEhDLzNmcHJrY0VHeUJUbEpqZTM5Uk8xeU02SFBvNkducmcxZDBHUFp3RVUwdy9KNytDQzJlRzNXMW1MWGFlWTlKMmcwdUZ6QTNPTTRhWjRHa1BoR1ZjSXZCQVo3aU1BRERtcmI0N0dvN2siLCJtYWMiOiI4NGEyNmUzYTFmNWJiM2VmZmM4YmNjN2JiOGVmMWRmYjAyYWM2NjIyZjg5MzZjZjcyNDkzMmFmY2IxNGZjMWVmIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:07 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6Ijk1aW4wWmZEVFE4MloydUxKbjBXK1E9PSIsInZhbHVlIjoid01GbjYvSURnUFJWV0F6NFBveHpxbEQzMjhXdXgybjl1ZnUvSnRKOFVsUXJNYzJIdzg5QU9VS3k2bUtHcnRsTU5nTTliKzZab2k1dnVDT25YcVlpcUVNVGJUNUp6Q3BXY1hwK0txbG9jUWpsVlAwYUc5VFJjWk5tVlU1aCs1Z0EiLCJtYWMiOiI2Yjg1YTVjNDRhODRkNDI3MDQzZDc0MTM1Y2Y1MGI0Y2EwZTYwZjdlODQxZmUwNmMwODE1OTVjNzdkZjI0ZGFmIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:07 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;

&lt;head&gt;

    
    &lt;meta charset=&quot;utf-8&quot;&gt;
    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;
    &lt;meta name=&quot;csrf-token&quot; content=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot;&gt;

    
        &lt;link rel=&quot;icon&quot; type=&quot;image/png&quot; href=&quot;http://localhost/brand-icon.png?v=5&quot;&gt;

    
    &lt;title&gt;
                Dashboard            &lt;/title&gt;

    
    &lt;!-- IFrame Preloader Removal Workaround --&gt;
    &lt;style type=&quot;text/css&quot;&gt;
        body.iframe-mode .preloader {
            display: none !important;
        }
    &lt;/style&gt;

    
    
    
                            &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/vendor/fontawesome-free/css/all.min.css&quot;&gt;
                &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/vendor/overlayScrollbars/css/OverlayScrollbars.min.css&quot;&gt;
                &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/vendor/adminlte/dist/css/adminlte.min.css&quot;&gt;

                                    &lt;link rel=&quot;stylesheet&quot; href=&quot;https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&quot;&gt;
                            
    
    &lt;link rel=&quot;stylesheet&quot; href=&quot;//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css&quot;&gt;
            
            

    

    
    

    

    

    
    

    

    

    
    

    

    

    
    

            
            

            
            

                            &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/css/variables-institucionales.css&quot;&gt;
            
            

    
    
    
                &lt;style&gt;
        .dashboard-card { border-radius: 10px; transition: transform 0.2s; }
        .dashboard-card:hover { transform: translateY(-3px); }
        .stat-card { border-left: 4px solid var(--gob-verde); }
        .stat-card-blue { border-left-color: #007bff; }
        .stat-card-orange { border-left-color: #fd7e14; }
        .stat-card-red { border-left-color: #dc3545; }
        .stat-card-purple { border-left-color: #6f42c1; }
        .stat-icon { font-size: 2rem; opacity: 0.8; }
        .stat-value { font-size: 1.8rem; font-weight: 700; }
        .indice-bar { height: 10px; border-radius: 5px; }
        .indice-label { font-size: 0.85rem; font-weight: 600; }
        .rank-medal { font-size: 1.5rem; }
        .alert-badge { display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; }
        .alert-badge-red { background-color: #f8d7da; color: #721c24; }
        .alert-badge-yellow { background-color: #fff3cd; color: #856404; }
        .alert-badge-green { background-color: #d4edda; color: #155724; }
        .alert-badge-gray { background-color: #e2e3e5; color: #383d41; }
        .detalle-row { display: none; }
        .detalle-row.show { display: table-row; }
        .expand-icon { cursor: pointer; user-select: none; }
    &lt;/style&gt;

    
    
&lt;/head&gt;

&lt;body class=&quot;sidebar-mini&quot; &gt;

    
        &lt;div class=&quot;wrapper&quot;&gt;

        
                    &lt;div class=&quot;preloader flex-column justify-content-center align-items-center&quot; style=&quot;&quot;&gt;

    
        
        &lt;img src=&quot;http://localhost/img/logos/logoAlimentacionBienestar1.png&quot;
             class=&quot;img-circle animation__shake&quot;
             alt=&quot;POA Preloader Image&quot;
             width=&quot;60&quot;
             height=&quot;60&quot;
             style=&quot;animation-iteration-count:infinite;&quot;&gt;

    
&lt;/div&gt;
        
        
                    &lt;nav class=&quot;main-header navbar
    navbar-expand
    navbar-white navbar-light&quot;&gt;

    
    &lt;ul class=&quot;navbar-nav&quot;&gt;
        
        &lt;li class=&quot;nav-item&quot;&gt;
    &lt;a class=&quot;nav-link&quot; data-widget=&quot;pushmenu&quot; href=&quot;#&quot;
                        &gt;
        &lt;i class=&quot;fas fa-bars&quot;&gt;&lt;/i&gt;
        &lt;span class=&quot;sr-only&quot;&gt;Toggle navigation&lt;/span&gt;
    &lt;/a&gt;
&lt;/li&gt;
        
        
        
            &lt;img src=&quot;/img/logos/logoAlimentacionBienestar.png&quot; style=&quot;height: 33px; margin-top: 5px; margin-left: 10px;&quot;&gt;
    &lt;/ul&gt;

    
    &lt;ul class=&quot;navbar-nav ml-auto&quot;&gt;
        
            &lt;img src=&quot;/img/logos/gobierno.png&quot; style=&quot;height: 33px; margin-top: 5px; margin-right: 10px;&quot;&gt;

        
        
        
        
        
            &lt;/ul&gt;

&lt;/nav&gt;
        
        
                    &lt;aside class=&quot;main-sidebar sidebar-dark-primary elevation-4&quot;&gt;

    
            &lt;a href=&quot;http://localhost/home&quot;
            class=&quot;brand-link &quot;
    &gt;

    
    &lt;img src=&quot;http://localhost/img/logos/logoAlimentacionBienestar1.png&quot;
         alt=&quot;POA Logo&quot;
         class=&quot;brand-image img-circle elevation-3&quot;
         style=&quot;opacity:.8&quot;&gt;

    
    &lt;span class=&quot;brand-text font-weight-light &quot;&gt;
        &lt;b&gt;POA&lt;/b&gt; Bienestar
    &lt;/span&gt;

&lt;/a&gt;
    
    
    &lt;div class=&quot;sidebar&quot;&gt;
        &lt;nav class=&quot;pt-2&quot;&gt;
            &lt;ul class=&quot;nav nav-pills nav-sidebar flex-column &quot;
                data-widget=&quot;treeview&quot; role=&quot;menu&quot;
                                &gt;
                
                &lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link active &quot;
       href=&quot;http://localhost&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-tachometer-alt &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Dashboard

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/importaciones&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-file-import &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Centro de Importaci&oacute;n

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/estado-resultados&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-chart-line &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Estado de Resultados

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/poa&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-bullseye &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Formato POA

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-header &quot;&gt;

    ACCOUNT SETTINGS

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/admin/settings&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-user &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Profile

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/admin/settings&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-lock &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Change Password

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

            &lt;/ul&gt;
        &lt;/nav&gt;
    &lt;/div&gt;

&lt;/aside&gt;
        
        
                    &lt;div class=&quot;content-wrapper&quot;&gt;

    
    
    
            &lt;div class=&quot;content-header&quot;&gt;
            &lt;div class=&quot;container-fluid&quot;&gt;
                    &lt;h1&gt;&lt;i class=&quot;fas fa-tachometer-alt text-institucional-verde&quot;&gt;&lt;/i&gt; Dashboard Operativo&lt;/h1&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    
    
    &lt;div class=&quot;content&quot;&gt;
        &lt;div class=&quot;container-fluid&quot;&gt;
                        
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-3&quot;&gt;
        &lt;div class=&quot;card stat-card dashboard-card&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;d-flex justify-content-between align-items-center&quot;&gt;
                    &lt;div&gt;
                        &lt;p class=&quot;text-muted mb-0&quot;&gt;Almacenes&lt;/p&gt;
                        &lt;h2 class=&quot;stat-value mb-0&quot;&gt;13&lt;/h2&gt;
                        &lt;small class=&quot;text-muted&quot;&gt;13 con datos&lt;/small&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;stat-icon text-institucional-verde&quot;&gt;
                        &lt;i class=&quot;fas fa-warehouse&quot;&gt;&lt;/i&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-3&quot;&gt;
                &lt;div class=&quot;card stat-card stat-card-red dashboard-card&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;d-flex justify-content-between align-items-center&quot;&gt;
                    &lt;div&gt;
                        &lt;p class=&quot;text-muted mb-0&quot;&gt;Eficiencia Global&lt;/p&gt;
                        &lt;h2 class=&quot;stat-value mb-0 text-danger&quot;&gt;
                            18.1%
                        &lt;/h2&gt;
                        &lt;small class=&quot;text-muted&quot;&gt;2026&lt;/small&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;stat-icon text-danger&quot;&gt;
                        &lt;i class=&quot;fas fa-chart-pie&quot;&gt;&lt;/i&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;progress mt-2&quot; style=&quot;height: 6px;&quot;&gt;
                    &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 18.137298471133%&quot;&gt;&lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-3&quot;&gt;
        &lt;div class=&quot;card stat-card stat-card-red dashboard-card&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;d-flex justify-content-between align-items-center&quot;&gt;
                    &lt;div&gt;
                        &lt;p class=&quot;text-muted mb-0&quot;&gt;En Rojo&lt;/p&gt;
                        &lt;h2 class=&quot;stat-value mb-0 text-danger&quot;&gt;12&lt;/h2&gt;
                        &lt;small class=&quot;text-muted&quot;&gt;&Iacute;ndice &amp;lt; 30%&lt;/small&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;stat-icon text-danger&quot;&gt;
                        &lt;i class=&quot;fas fa-exclamation-triangle&quot;&gt;&lt;/i&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-3&quot;&gt;
        &lt;div class=&quot;card stat-card stat-card-orange dashboard-card&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;d-flex justify-content-between align-items-center&quot;&gt;
                    &lt;div&gt;
                        &lt;p class=&quot;text-muted mb-0&quot;&gt;Atenci&oacute;n&lt;/p&gt;
                        &lt;h2 class=&quot;stat-value mb-0 text-warning&quot;&gt;1&lt;/h2&gt;
                        &lt;small class=&quot;text-muted&quot;&gt;&Iacute;ndice 30-50%&lt;/small&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;stat-icon text-warning&quot;&gt;
                        &lt;i class=&quot;fas fa-exclamation-circle&quot;&gt;&lt;/i&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;


&lt;div class=&quot;row mt-3&quot;&gt;
    &lt;div class=&quot;col-md-7&quot;&gt;
        &lt;div class=&quot;card&quot;&gt;
            &lt;div class=&quot;card-header&quot;&gt;
                &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-list text-danger&quot;&gt;&lt;/i&gt; Almacenes por &Iacute;ndice de Eficiencia&lt;/h3&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body p-2&quot;&gt;
                                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; ALMACEN CENTRAL OAXACA
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;3.9%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 3.8548612800054%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; SAN JOSE EL CHILAR
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;15.8%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 15.762718526586%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; IXTLAN DE JUAREZ
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;15.9%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 15.934152755552%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; AYUTLA MIXES
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;16.2%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 16.165989794395%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; SAN ANDRES HIDALGO
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;16.6%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 16.617492277745%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; CUAJIMOLOYAS
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;16.9%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 16.85560246049%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; SANTIAGO TEOTITLAN
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;17.0%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 17.021849889397%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; SAN PEDRO JUCHATENGO
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;17.1%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 17.059034673273%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; TAMAZULAPAN
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;18.4%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 18.438126269867%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; LACHIXIO
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;20.8%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 20.76865136305%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; SANTIAGO MATATLAN
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;21.0%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 20.963106168558%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; MAGDALENA OCOTLAN
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-red&quot;&gt;21.9%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 21.903202908888%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;mb-2 px-1&quot;&gt;
                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                                &lt;span class=&quot;indice-label&quot;&gt;
                                    &lt;i class=&quot;fas fa-store text-muted mr-1&quot;&gt;&lt;/i&gt; VALLES CENTRALES
                                &lt;/span&gt;
                                &lt;span class=&quot;alert-badge alert-badge-yellow&quot;&gt;34.4%&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;progress indice-bar&quot;&gt;
                                &lt;div class=&quot;progress-bar bg-warning&quot; style=&quot;width: 34.440091756923%&quot;&gt;&lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                                                &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-5&quot;&gt;
        &lt;div class=&quot;card&quot;&gt;
            &lt;div class=&quot;card-header&quot;&gt;
                &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-trophy text-warning&quot;&gt;&lt;/i&gt; Top 3 / Bottom 3&lt;/h3&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                                    &lt;p class=&quot;font-weight-bold text-success mb-2&quot;&gt;&lt;i class=&quot;fas fa-arrow-up&quot;&gt;&lt;/i&gt; Mejores&lt;/p&gt;
                                                                    &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                            &lt;span&gt;&lt;span class=&quot;rank-medal&quot;&gt;🥇&lt;/span&gt; VALLES CENTRALES&lt;/span&gt;
                            &lt;span class=&quot;font-weight-bold text-success&quot;&gt;34.4%&lt;/span&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                            &lt;span&gt;&lt;span class=&quot;rank-medal&quot;&gt;🥈&lt;/span&gt; MAGDALENA OCOTLAN&lt;/span&gt;
                            &lt;span class=&quot;font-weight-bold text-success&quot;&gt;21.9%&lt;/span&gt;
                        &lt;/div&gt;
                                                                    &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                            &lt;span&gt;&lt;span class=&quot;rank-medal&quot;&gt;🥉&lt;/span&gt; SANTIAGO MATATLAN&lt;/span&gt;
                            &lt;span class=&quot;font-weight-bold text-success&quot;&gt;21.0%&lt;/span&gt;
                        &lt;/div&gt;
                                        &lt;hr&gt;
                    &lt;p class=&quot;font-weight-bold text-danger mb-2&quot;&gt;&lt;i class=&quot;fas fa-arrow-down&quot;&gt;&lt;/i&gt; Peores&lt;/p&gt;
                                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                            &lt;span&gt;&lt;span class=&quot;rank-medal&quot;&gt;⚠️&lt;/span&gt; ALMACEN CENTRAL OAXACA&lt;/span&gt;
                            &lt;span class=&quot;font-weight-bold text-danger&quot;&gt;3.9%&lt;/span&gt;
                        &lt;/div&gt;
                                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                            &lt;span&gt;&lt;span class=&quot;rank-medal&quot;&gt;⚠️&lt;/span&gt; SAN JOSE EL CHILAR&lt;/span&gt;
                            &lt;span class=&quot;font-weight-bold text-danger&quot;&gt;15.8%&lt;/span&gt;
                        &lt;/div&gt;
                                            &lt;div class=&quot;d-flex justify-content-between align-items-center mb-1&quot;&gt;
                            &lt;span&gt;&lt;span class=&quot;rank-medal&quot;&gt;⚠️&lt;/span&gt; IXTLAN DE JUAREZ&lt;/span&gt;
                            &lt;span class=&quot;font-weight-bold text-danger&quot;&gt;15.9%&lt;/span&gt;
                        &lt;/div&gt;
                                                &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;


&lt;div class=&quot;row mt-3&quot;&gt;
    &lt;div class=&quot;col-md-12&quot;&gt;
        &lt;div class=&quot;card&quot;&gt;
            &lt;div class=&quot;card-header&quot;&gt;
                &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-table&quot;&gt;&lt;/i&gt; Detalle de Eficiencia por Almac&eacute;n&lt;/h3&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body p-0&quot;&gt;
                &lt;div class=&quot;table-responsive&quot;&gt;
                    &lt;table class=&quot;table table-bordered table-hover mb-0&quot;&gt;
                        &lt;thead class=&quot;bg-institucional-verde text-white&quot;&gt;
                            &lt;tr&gt;
                                &lt;th style=&quot;width: 30px;&quot;&gt;&lt;/th&gt;
                                &lt;th&gt;Almac&eacute;n&lt;/th&gt;
                                &lt;th class=&quot;text-center&quot; style=&quot;width: 120px;&quot;&gt;&Iacute;ndice Global&lt;/th&gt;
                                &lt;th style=&quot;width: 200px;&quot;&gt;Barra&lt;/th&gt;
                                &lt;th class=&quot;text-center&quot; style=&quot;width: 100px;&quot;&gt;Conceptos&lt;/th&gt;
                                &lt;th style=&quot;width: 80px;&quot;&gt;Detalle&lt;/th&gt;
                            &lt;/tr&gt;
                        &lt;/thead&gt;
                        &lt;tbody&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(0)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-0&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;ALMACEN CENTRAL OAXACA&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        3.9%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 3.8548612800054%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;1&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;1 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-0&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $133,753,970.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $5,156,030.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            3.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(1)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-1&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;SAN JOSE EL CHILAR&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        15.8%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 15.762718526586%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-1&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $46,970,655.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $8,035,349.47
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            17.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $4,688,608.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $19,138.46
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $51,659,263.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $8,054,487.93
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            15.6%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9,996,583.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $2,065,320.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            20.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            14.46%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            14.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            89.40%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            89.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $58,337.92
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $7.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $2.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(2)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-2&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;IXTLAN DE JUAREZ&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        15.9%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 15.934152755552%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-2&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $45,050,588.18
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $8,378,829.44
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            18.6%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10,729,669.95
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $33,302.44
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.3%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $55,780,258.13
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $8,412,131.88
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            15.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10,342,499.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $1,841,130.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            17.8%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            15.66%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            15.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            91.89%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            91.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $59,160.77
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $7.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $6.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $1.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(3)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-3&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;AYUTLA MIXES&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        16.2%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 16.165989794395%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-3&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $85,705,998.02
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $14,691,639.85
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            17.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $3,881,374.65
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $6,041.77
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $89,587,372.67
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $14,697,681.62
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            16.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $16,576,720.30
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $2,517,250.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            15.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            11.49%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            11.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            98.76%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            98.8%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $119,103.20
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $3,002.48
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            2.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $12.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $5.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $7.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(4)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-4&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;SAN ANDRES HIDALGO&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        16.6%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 16.617492277745%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-4&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $48,222,093.79
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $7,956,835.42
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            16.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $2,492,578.99
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $29,580.63
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            1.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $50,714,672.76
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $7,986,416.05
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            15.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10,336,541.21
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $1,673,490.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            16.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            21.69%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            21.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            94.86%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            94.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $62,823.58
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $5.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $4.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(5)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-5&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;CUAJIMOLOYAS&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        16.9%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 16.85560246049%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-5&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $35,410,296.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $6,513,612.18
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            18.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $4,732,293.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $9,474.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $40,142,590.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $6,523,086.18
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            16.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $4,117,995.60
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $1,392,350.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            33.8%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            8.49%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            8.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            91.41%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            91.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $37,264.23
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $6.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $3.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $3.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(6)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-6&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;SANTIAGO TEOTITLAN&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        17.0%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 17.021849889397%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;9&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;9 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-6&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $44,168,422.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $8,576,474.52
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            19.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $4,501,952.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $20,910.40
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $48,670,374.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $8,597,384.92
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            17.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9,140,369.39
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            21.63%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            21.6%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            94.02%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            94.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $58,036.03
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $6.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $6.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(7)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-7&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;SAN PEDRO JUCHATENGO&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        17.1%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 17.059034673273%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-7&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $57,218,000.92
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $10,979,906.54
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            19.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $1,004,736.43
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $14,679.71
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            1.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $58,222,737.35
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $10,994,586.25
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            18.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $11,422,453.56
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $2,092,140.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            18.3%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            17.76%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            17.8%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            94.98%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            95.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $69,680.84
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $1.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $8.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(8)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-8&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;TAMAZULAPAN&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        18.4%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 18.438126269867%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-8&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $104,095,678.41
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $19,649,591.54
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            18.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $3,314,364.98
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $101,980.85
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            3.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $107,410,043.36
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $19,751,572.39
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            18.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;RESULTADO DIRECTO DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $8,131,570.21
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $-418,830.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $14,811,932.20
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $1,503,250.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            10.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            41.64%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-warning&quot;&gt;
                                                            41.6%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            92.25%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            92.3%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $177,818.87
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $15.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $15.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(9)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-9&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;LACHIXIO&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        20.8%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 20.76865136305%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;9&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;9 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-9&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $46,573,409.23
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $9,635,801.04
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            20.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $350,000.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $23,043.51
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            6.6%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $46,923,409.23
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $9,658,844.55
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            20.6%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $6,365,443.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $1,725,050.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            27.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            20.22%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            20.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            91.74%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            91.7%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $54,824.85
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(10)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-10&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;SANTIAGO MATATLAN&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        21.0%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 20.963106168558%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;9&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;9 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-10&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $42,504,643.78
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $7,172,283.55
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            16.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $2,606,465.24
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $9,340.85
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $45,111,109.03
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $7,181,624.40
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            15.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10,419,719.78
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $3,284,880.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            31.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            25.11%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            25.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            98.88%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            98.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $60,101.89
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $10.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-danger&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(11)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-11&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;MAGDALENA OCOTLAN&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        21.9%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-danger&quot; style=&quot;width: 21.903202908888%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;8&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;8 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-11&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $37,581,155.83
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $7,608,929.50
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            20.2%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $37,581,155.83
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $7,625,900.53
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            20.3%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $22,818,203.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $1,468,840.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            6.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            29.88%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            29.9%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            98.37%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            98.4%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $54,455.28
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $9.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                                                            &lt;tr class=&quot;table-warning&quot;&gt;
                                    &lt;td class=&quot;text-center expand-icon&quot; onclick=&quot;toggleDetalle(12)&quot;&gt;
                                        &lt;i class=&quot;fas fa-plus-circle text-primary&quot; id=&quot;icon-12&quot;&gt;&lt;/i&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;font-weight-bold&quot;&gt;VALLES CENTRALES&lt;/td&gt;
                                    &lt;td class=&quot;text-center font-weight-bold&quot;&gt;
                                        34.4%
                                    &lt;/td&gt;
                                    &lt;td&gt;
                                        &lt;div class=&quot;progress&quot; style=&quot;height: 8px;&quot;&gt;
                                            &lt;div class=&quot;progress-bar bg-warning&quot; style=&quot;width: 34.440091756923%&quot;&gt;&lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;10&lt;/td&gt;
                                    &lt;td class=&quot;text-center&quot;&gt;
                                                                                    &lt;span class=&quot;badge bg-info text-white&quot;&gt;10 conceptos&lt;/span&gt;
                                                                            &lt;/td&gt;
                                &lt;/tr&gt;
                                &lt;tr class=&quot;detalle-row&quot; id=&quot;detalle-12&quot;&gt;
                                    &lt;td colspan=&quot;6&quot; class=&quot;p-0&quot;&gt;
                                        &lt;table class=&quot;table table-sm table-striped mb-0&quot;&gt;
                                            &lt;thead&gt;
                                                &lt;tr class=&quot;bg-light&quot;&gt;
                                                    &lt;th style=&quot;width: 40%; padding-left: 40px;&quot;&gt;Concepto&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;META&lt;/th&gt;
                                                    &lt;th class=&quot;text-right&quot; style=&quot;width: 20%;&quot;&gt;REAL&lt;/th&gt;
                                                    &lt;th class=&quot;text-center&quot; style=&quot;width: 20%;&quot;&gt;% Logro&lt;/th&gt;
                                                &lt;/tr&gt;
                                            &lt;/thead&gt;
                                            &lt;tbody&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PAR&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $45,710,806.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $68,989,542.61
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            100.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA PE&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $8,043,185.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $387,952.77
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            4.8%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;PRESUPUESTO DE VENTA TOTAL&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $53,753,991.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $69,377,495.38
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            100.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;RESULTADO DIRECTO DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $41,146,521.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $-701,120.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;GASTOS DE OPERACI&Oacute;N&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $7,405,510.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $701,120.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            9.5%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;OPORTUNIDAD DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            31.11%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            31.1%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;EFICIENCIA DE SURTIMIENTO A TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            100%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            99.00%
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-success&quot;&gt;
                                                            99.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;MERMAS, QUEBRANTOS Y MAL ESTADO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $58,523.45
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $27.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                                                                                        &lt;tr&gt;
                                                        &lt;td style=&quot;padding-left: 40px;&quot;&gt;APERTURA DE TIENDAS LOCALIDAD OBJETIVO&lt;/td&gt;
                                                        &lt;td class=&quot;text-right font-weight-bold&quot;&gt;
                                                                                                                            $27.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-right&quot;&gt;
                                                                                                                            $0.00
                                                                                                                    &lt;/td&gt;
                                                        &lt;td class=&quot;text-center font-weight-bold text-danger&quot;&gt;
                                                            0.0%
                                                        &lt;/td&gt;
                                                    &lt;/tr&gt;
                                                                                            &lt;/tbody&gt;
                                        &lt;/table&gt;
                                    &lt;/td&gt;
                                &lt;/tr&gt;
                                                    &lt;/tbody&gt;
                    &lt;/table&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;
        
        
        
        
        
    &lt;/div&gt;

    
                            &lt;script src=&quot;http://localhost/vendor/jquery/jquery.min.js&quot;&gt;&lt;/script&gt;
                &lt;script src=&quot;http://localhost/vendor/bootstrap/js/bootstrap.bundle.min.js&quot;&gt;&lt;/script&gt;
                &lt;script src=&quot;http://localhost/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js&quot;&gt;&lt;/script&gt;
                &lt;script src=&quot;http://localhost/vendor/adminlte/dist/js/adminlte.min.js&quot;&gt;&lt;/script&gt;
            
    
    &lt;script src=&quot;//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js&quot; &gt;&lt;/script&gt;
            
        
            

            
            

            
            

    

    
    

    

    

    
    

    

    

    
    

    

    

    
    

            
            

            
            

            
            

    
    
    
            &lt;script&gt;
    window.toggleDetalle = function(index) {
        var row = document.getElementById(&#039;detalle-&#039; + index);
        var icon = document.getElementById(&#039;icon-&#039; + index);
        if (row.classList.contains(&#039;show&#039;)) {
            row.classList.remove(&#039;show&#039;);
            icon.className = &#039;fas fa-plus-circle text-primary&#039;;
        } else {
            row.classList.add(&#039;show&#039;);
            icon.className = &#039;fas fa-minus-circle text-primary&#039;;
        }
    };
&lt;/script&gt;

&lt;/body&gt;

&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GET-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GET-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GET-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GET-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GET-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GET-" data-method="GET"
      data-path="/"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GET-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>/</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GET-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GET-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTadminlte-darkmode-toggle">Toggle the dark mode preference.</h2>

<p>
</p>



<span id="example-requests-POSTadminlte-darkmode-toggle">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/adminlte/darkmode/toggle" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/adminlte/darkmode/toggle"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTadminlte-darkmode-toggle">
</span>
<span id="execution-results-POSTadminlte-darkmode-toggle" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTadminlte-darkmode-toggle"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTadminlte-darkmode-toggle"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTadminlte-darkmode-toggle" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTadminlte-darkmode-toggle">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTadminlte-darkmode-toggle" data-method="POST"
      data-path="adminlte/darkmode/toggle"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTadminlte-darkmode-toggle', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>adminlte/darkmode/toggle</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTadminlte-darkmode-toggle"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTadminlte-darkmode-toggle"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTlivewire-88aad302-update">POST livewire-88aad302/update</h2>

<p>
</p>



<span id="example-requests-POSTlivewire-88aad302-update">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/livewire-88aad302/update" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/update"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTlivewire-88aad302-update">
</span>
<span id="execution-results-POSTlivewire-88aad302-update" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTlivewire-88aad302-update"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTlivewire-88aad302-update"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTlivewire-88aad302-update" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTlivewire-88aad302-update">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTlivewire-88aad302-update" data-method="POST"
      data-path="livewire-88aad302/update"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTlivewire-88aad302-update', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>livewire-88aad302/update</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTlivewire-88aad302-update"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTlivewire-88aad302-update"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETlivewire-88aad302-livewire-min-js">GET livewire-88aad302/livewire.min.js</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-livewire-min-js">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/livewire.min.js" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/livewire.min.js"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-livewire-min-js">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: application/javascript; charset=utf-8
expires: Tue, 18 May 2027 20:18:03 GMT
cache-control: max-age=31536000, public
accept-ranges: bytes
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-livewire-min-js" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-livewire-min-js"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-livewire-min-js"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-livewire-min-js" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-livewire-min-js">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-livewire-min-js" data-method="GET"
      data-path="livewire-88aad302/livewire.min.js"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-livewire-min-js', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/livewire.min.js</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-livewire-min-js"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-livewire-min-js"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETlivewire-88aad302-livewire-min-js-map">GET livewire-88aad302/livewire.min.js.map</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-livewire-min-js-map">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/livewire.min.js.map" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/livewire.min.js.map"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-livewire-min-js-map">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: application/javascript; charset=utf-8
expires: Tue, 18 May 2027 20:18:03 GMT
cache-control: max-age=31536000, public
accept-ranges: bytes
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-livewire-min-js-map" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-livewire-min-js-map"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-livewire-min-js-map"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-livewire-min-js-map" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-livewire-min-js-map">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-livewire-min-js-map" data-method="GET"
      data-path="livewire-88aad302/livewire.min.js.map"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-livewire-min-js-map', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/livewire.min.js.map</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-livewire-min-js-map"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-livewire-min-js-map"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETlivewire-88aad302-livewire-csp-min-js-map">GET livewire-88aad302/livewire.csp.min.js.map</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-livewire-csp-min-js-map">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/livewire.csp.min.js.map" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/livewire.csp.min.js.map"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-livewire-csp-min-js-map">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: application/javascript; charset=utf-8
expires: Tue, 18 May 2027 20:18:03 GMT
cache-control: max-age=31536000, public
accept-ranges: bytes
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-livewire-csp-min-js-map" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-livewire-csp-min-js-map"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-livewire-csp-min-js-map"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-livewire-csp-min-js-map" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-livewire-csp-min-js-map">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-livewire-csp-min-js-map" data-method="GET"
      data-path="livewire-88aad302/livewire.csp.min.js.map"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-livewire-csp-min-js-map', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/livewire.csp.min.js.map</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-livewire-csp-min-js-map"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-livewire-csp-min-js-map"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTlivewire-88aad302-upload-file">POST livewire-88aad302/upload-file</h2>

<p>
</p>



<span id="example-requests-POSTlivewire-88aad302-upload-file">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/livewire-88aad302/upload-file" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/upload-file"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTlivewire-88aad302-upload-file">
</span>
<span id="execution-results-POSTlivewire-88aad302-upload-file" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTlivewire-88aad302-upload-file"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTlivewire-88aad302-upload-file"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTlivewire-88aad302-upload-file" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTlivewire-88aad302-upload-file">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTlivewire-88aad302-upload-file" data-method="POST"
      data-path="livewire-88aad302/upload-file"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTlivewire-88aad302-upload-file', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>livewire-88aad302/upload-file</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTlivewire-88aad302-upload-file"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTlivewire-88aad302-upload-file"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETlivewire-88aad302-preview-file--filename-">GET livewire-88aad302/preview-file/{filename}</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-preview-file--filename-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/preview-file/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/preview-file/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-preview-file--filename-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
set-cookie: XSRF-TOKEN=eyJpdiI6InBGS215YkVMYUJOc3kxTzhYS2JOK2c9PSIsInZhbHVlIjoicDZKOTVmNFdwT2ZvM0orSFMvelJxQndrRW5LR1NuUUZOTlM4YS9iUDZJUzRBempORHk5ekNNSy91bWMzdFFlVUt6YkE1R2dPSGxVWGlTQ1QwRmxjUTF1eWIxcGhUWUNvZ3FhcVJOTWxrWVk0T2FvVjZXbW5VOWw2VXJHVEhVSmEiLCJtYWMiOiI3ZTFiZmJiZmY5MmE0ZDkwZTRhYWY2MjVmZDRjZjIyZWUzNmZkMDUyOGUxMDk5MjZhZTViOGEzZTdkODgyYTQzIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:04 GMT; Max-Age=7199; path=/; samesite=lax; laravel-session=eyJpdiI6Ino3akR5MUI5aEFaVEUzQ0Y4MGM3Tnc9PSIsInZhbHVlIjoiZmJKVkV4MVFnU2hQZHhuQ3VRbTc3d1BMc2FHTElZeVNvVXJoejJvOFZkMEdQOU10L21tVlkvMGprZVNnbW1UYktsUTIvNDRpb1o0Y3VKbkZrMy9oWTgrN1lnUHQ0UjNVdzZDaUk5SFpJMXNFVUNKa2xXS3I4SkJKbWxaUUJkcDMiLCJtYWMiOiI3NTFjYzUwZjgzZGM0ZTI2OTJmNDNmN2YyNDVhYmIwMTU1ZDNkMDY1YTNjZGI3NDFjYTZmMjVjYjc4MjkzOGU5IiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:04 GMT; Max-Age=7199; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-preview-file--filename-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-preview-file--filename-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-preview-file--filename-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-preview-file--filename-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-preview-file--filename-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-preview-file--filename-" data-method="GET"
      data-path="livewire-88aad302/preview-file/{filename}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-preview-file--filename-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/preview-file/{filename}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-preview-file--filename-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-preview-file--filename-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filename</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filename"                data-endpoint="GETlivewire-88aad302-preview-file--filename-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETlivewire-88aad302-js--component--js">GET livewire-88aad302/js/{component}.js</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-js--component--js">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/js/consequatur.js" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/js/consequatur.js"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-js--component--js">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-js--component--js" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-js--component--js"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-js--component--js"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-js--component--js" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-js--component--js">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-js--component--js" data-method="GET"
      data-path="livewire-88aad302/js/{component}.js"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-js--component--js', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/js/{component}.js</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-js--component--js"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-js--component--js"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>component</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="component"                data-endpoint="GETlivewire-88aad302-js--component--js"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETlivewire-88aad302-css--component--css">GET livewire-88aad302/css/{component}.css</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-css--component--css">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/css/consequatur.css" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/css/consequatur.css"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-css--component--css">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-css--component--css" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-css--component--css"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-css--component--css"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-css--component--css" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-css--component--css">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-css--component--css" data-method="GET"
      data-path="livewire-88aad302/css/{component}.css"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-css--component--css', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/css/{component}.css</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-css--component--css"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-css--component--css"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>component</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="component"                data-endpoint="GETlivewire-88aad302-css--component--css"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETlivewire-88aad302-css--component--global-css">GET livewire-88aad302/css/{component}.global.css</h2>

<p>
</p>



<span id="example-requests-GETlivewire-88aad302-css--component--global-css">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/livewire-88aad302/css/consequatur.global.css" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/livewire-88aad302/css/consequatur.global.css"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlivewire-88aad302-css--component--global-css">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETlivewire-88aad302-css--component--global-css" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlivewire-88aad302-css--component--global-css"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlivewire-88aad302-css--component--global-css"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlivewire-88aad302-css--component--global-css" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlivewire-88aad302-css--component--global-css">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlivewire-88aad302-css--component--global-css" data-method="GET"
      data-path="livewire-88aad302/css/{component}.global.css"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlivewire-88aad302-css--component--global-css', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>livewire-88aad302/css/{component}.global.css</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlivewire-88aad302-css--component--global-css"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlivewire-88aad302-css--component--global-css"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>component</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="component"                data-endpoint="GETlivewire-88aad302-css--component--global-css"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETup">GET up</h2>

<p>
</p>



<span id="example-requests-GETup">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/up" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/up"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETup">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;utf-8&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;

    &lt;title&gt;Laravel&lt;/title&gt;

    &lt;!-- Fonts --&gt;
    &lt;link rel=&quot;preconnect&quot; href=&quot;https://fonts.bunny.net&quot;&gt;
    &lt;link href=&quot;https://fonts.bunny.net/css?family=figtree:400,600&amp;display=swap&quot; rel=&quot;stylesheet&quot; /&gt;

    &lt;!-- Styles --&gt;
    &lt;script src=&quot;https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4&quot;&gt;&lt;/script&gt;

    &lt;style type=&quot;text/tailwindcss&quot;&gt;
        @theme {
            --font-sans: &#039;Figtree&#039;, &#039;ui-sans-serif&#039;, &#039;system-ui&#039;, &#039;sans-serif&#039;, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body class=&quot;antialiased&quot;&gt;
&lt;div class=&quot;relative flex justify-center items-center min-h-screen bg-gray-100 selection:bg-red-500 selection:text-white&quot;&gt;
    &lt;div class=&quot;w-full sm:w-3/4 xl:w-1/2 mx-auto p-6&quot;&gt;
        &lt;div class=&quot;px-6 py-4 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex items-center focus:outline focus:outline-2 focus:outline-red-500&quot;&gt;
            &lt;div class=&quot;relative flex h-3 w-3 group &quot;&gt;
                &lt;span class=&quot;animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 group-[.status-down]:bg-red-600 opacity-75&quot;&gt;&lt;/span&gt;
                &lt;span class=&quot;relative inline-flex rounded-full h-3 w-3 bg-green-400 group-[.status-down]:bg-red-600&quot;&gt;&lt;/span&gt;
            &lt;/div&gt;

            &lt;div class=&quot;ml-6&quot;&gt;
                &lt;h2 class=&quot;text-xl font-semibold text-gray-900&quot;&gt;Application up&lt;/h2&gt;

                &lt;p class=&quot;mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed&quot;&gt;
                    HTTP request received.

                                            Response rendered in 5357ms.
                                    &lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GETup" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETup"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETup"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETup" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETup">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETup" data-method="GET"
      data-path="up"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETup', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>up</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETup"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETup"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETstorage--path-">GET storage/{path}</h2>

<p>
</p>



<span id="example-requests-GETstorage--path-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/storage/2UZ5i" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/storage/2UZ5i"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETstorage--path-">
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETstorage--path-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETstorage--path-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETstorage--path-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETstorage--path-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETstorage--path-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETstorage--path-" data-method="GET"
      data-path="storage/{path}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETstorage--path-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>storage/{path}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETstorage--path-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETstorage--path-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>path</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="path"                data-endpoint="GETstorage--path-"
               value="2UZ5i"
               data-component="url">
    <br>
<p>Example: <code>2UZ5i</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTstorage--path-">PUT storage/{path}</h2>

<p>
</p>



<span id="example-requests-PUTstorage--path-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/storage/2UZ5i" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/storage/2UZ5i"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTstorage--path-">
</span>
<span id="execution-results-PUTstorage--path-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTstorage--path-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTstorage--path-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTstorage--path-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTstorage--path-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTstorage--path-" data-method="PUT"
      data-path="storage/{path}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTstorage--path-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>storage/{path}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTstorage--path-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTstorage--path-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>path</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="path"                data-endpoint="PUTstorage--path-"
               value="2UZ5i"
               data-component="url">
    <br>
<p>Example: <code>2UZ5i</code></p>
            </div>
                    </form>

                <h1 id="estado-de-resultados">Estado de Resultados</h1>

    

                                <h2 id="estado-de-resultados-GETestado-resultados">Mostrar Estado de Resultados</h2>

<p>
</p>

<p>Renderiza la tabla del Estado de Resultados con filtros por almacén y año.
Muestra los 12 meses con totales anuales para cada concepto ER.
Si la petición es AJAX, devuelve solo el HTML de la tabla.</p>

<span id="example-requests-GETestado-resultados">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/estado-resultados?anio=17&amp;almacen_id=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/estado-resultados"
);

const params = {
    "anio": "17",
    "almacen_id": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETestado-resultados">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=utf-8
cache-control: no-cache, private
set-cookie: XSRF-TOKEN=eyJpdiI6IjFYYm81a0g1RGMvR2dhWjh2QlYrOXc9PSIsInZhbHVlIjoiWXFOU2M4alRzYjllcU00MmYwanhzbEdCS05QeVd6a2h3c3ZkTGlveUZqMGJpbmdxeVhnbjBNYjBzQityL2FyVTBHcXJPVVRSTEhxUG1QaDFXaGhVVzNObFYvN292b2FJRzFxQW1XZm1lWFhUVUFJT0twYnlyQ2g2TU5OMXlhTmMiLCJtYWMiOiIwMjAzODcyZmU2YzI1OWViYzFhNDk0NjcwMDE0YmVmNTA2NWU4YmYxODI2NTE2ODg5Zjc1ZjU3YzZhY2VlZWU4IiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:09 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6InVFY2FKSThQSDlNaFZwQW1jMTJqZkE9PSIsInZhbHVlIjoiNWowMjN1REV1TmNDRFpscjRxOXdKZlhPWllMd1pVczVFVFZpME9WWFJUd1hTY2FXSmdxT3FQR25meHBiczJ1NHRRK1d1SjIxSTRaYS91Y29jMGZaMGFVR3dhYnZtd3dwbmYwUVVUS2pHTWtvMXpnQm1Qa0x3b2xhNTBCN0hUbVUiLCJtYWMiOiIxMjhlZWQ4Mzg1ZDE3MDI3MWQzNGU1YjVhOTgyMzIzZjE3ZWE3M2I3NWQ4N2U3NGMzNGM3YzRmOWMzOWVmNWQ2IiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:09 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;div class=&quot;table-responsive&quot;&gt;
    &lt;div id=&quot;contenedor-tabla-er&quot;&gt;
    &lt;table class=&quot;table table-sm table-hover text-right table-er&quot; style=&quot;font-size: 0.85rem; white-space: nowrap;&quot;&gt;
        &lt;thead class=&quot;text-center&quot;&gt;
            &lt;tr&gt;
                &lt;th class=&quot;text-left&quot; style=&quot;min-width: 250px;&quot;&gt;CONCEPTO&lt;/th&gt;
                &lt;th&gt;ENERO&lt;/th&gt;
                &lt;th&gt;FEBRERO&lt;/th&gt;
                &lt;th&gt;MARZO&lt;/th&gt;
                &lt;th&gt;ABRIL&lt;/th&gt;
                &lt;th&gt;MAYO&lt;/th&gt;
                &lt;th&gt;JUNIO&lt;/th&gt;
                &lt;th&gt;JULIO&lt;/th&gt;
                &lt;th&gt;AGOSTO&lt;/th&gt;
                &lt;th&gt;SEPTIEMBRE&lt;/th&gt;
                &lt;th&gt;OCTUBRE&lt;/th&gt;
                &lt;th&gt;NOVIEMBRE&lt;/th&gt;
                &lt;th&gt;DICIEMBRE&lt;/th&gt;
                &lt;th class=&quot;bg-dark&quot;&gt;TOTAL&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        VENTAS A TIENDAS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        VENTAS PROGRAMAS ESPECIALES
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        VENTAS NETAS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        COSTO DE VENTA
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        REMANENTE BRUTO
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        GASTOS DE DISTRIBUCION
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        REMUNERACION Y PREV. SOCIAL
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        SERVICIO A COMUNIDADES
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        COMBUSTIBLE Y LUBRICANTES
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        MTTO CONSV. Y REPARA.
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        MTTO DE EQUIPO DE TRANSP.
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        FLETES Y MANIOBRAS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        ALMACENAJE
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        DEPRECIACIONES Y AMORTIZACIONES
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        GASTOS DE VIAJE
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        MATERIALES Y SERVICIOS DE OFICINA
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        PRIMA DE SEGUROS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        ESTIMACION PARA CUENTAS INCOBRABLES
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        DIVERSOS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        ASESORIAS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        IMPUESTOS Y DERECHOS
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        LIQUIDACION
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        TOTAL DE GTOS DE DISTRIBUCION
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                                            &lt;tr class=&quot;&quot;&gt;
                    &lt;td class=&quot;text-left concepto-col  pl-4&quot;&gt;
                        RESULTADO DIRECTO DE OPERACI&Oacute;N
                    &lt;/td&gt;
                    
                                                                                                    &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                                                &lt;td class=&quot;er-monto er-monto-cero &quot;&gt;
                                                                    &lt;span class=&quot;text-muted-dash&quot;&gt;-&lt;/span&gt;
                                                            &lt;/td&gt;
                                                &lt;td class=&quot;font-weight-bold total-col er-monto er-monto-cero &quot;&gt;
                            -
                        &lt;/td&gt;
                                    &lt;/tr&gt;
                    &lt;/tbody&gt;
    &lt;/table&gt;
&lt;/div&gt;
&lt;/div&gt;</code>
 </pre>
    </span>
<span id="execution-results-GETestado-resultados" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETestado-resultados"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETestado-resultados"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETestado-resultados" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETestado-resultados">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETestado-resultados" data-method="GET"
      data-path="estado-resultados"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETestado-resultados', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>estado-resultados</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETestado-resultados"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETestado-resultados"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="GETestado-resultados"
               value="17"
               data-component="query">
    <br>
<p>Año (default: año actual). Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="GETestado-resultados"
               value="17"
               data-component="query">
    <br>
<p>ID del almacén (opcional, para vista individual). Example: <code>17</code></p>
            </div>
                </form>

                    <h2 id="estado-de-resultados-GETestado-resultados-export">Exportar Estado de Resultados (Excel)</h2>

<p>
</p>

<p>Descarga la matriz del Estado de Resultados en formato Excel (.xlsx)
con todos los conceptos ER y sus valores mensuales.</p>

<span id="example-requests-GETestado-resultados-export">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/estado-resultados/export?anio=17&amp;almacen_id=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/estado-resultados/export"
);

const params = {
    "anio": "17",
    "almacen_id": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETestado-resultados-export">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: public
content-disposition: attachment; filename=Estado_Resultados_17_Almacen_17.xlsx
content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
accept-ranges: bytes
set-cookie: XSRF-TOKEN=eyJpdiI6IkNUdXhvY3B5Q3dKbHRYMzFMQlEzbFE9PSIsInZhbHVlIjoiVnpnUTg5RlA0U242QTlMN1AzeFpodFlwb0lXTHhhZC9hdzdqeE1aNVA5dTVubUdMQXVJVWpzdlM5ODBJYUNZQTh5cTZYOERsOXhpbGl0ZjNjSG9ZbzQwaGg2VTBOMVZRMkRhTHRkL1RocDdoWjFNRUV6STgvTjRFVEFWeVRFOEkiLCJtYWMiOiJhMjBjODBiYjBjZDAwNzI2MGYyMDY1ZjUwZmE1Mjg5NjFjMTU4OTM4MTQwNGMwNzhjYTIwMGJjMWU1YWU5MWYxIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:10 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6IjRWbjNPajRUUldqRTdUazFkQSs2OVE9PSIsInZhbHVlIjoiMkJaRExJcFRMcUpUcE5tSXUwS1F6cFpYYVBROWxRTFJPQ3FaUVdtUm9XclIwVmJNWXNIaHhtdVNHYVJtMlNaNW1ZYklMak9DbUx5RGQxZDlYbHJ5TkJnNmV3NGNxcWtlanI3ZlpXdElwWStmcHZxRGFHaGJTMGt4L2kyZ01FdjMiLCJtYWMiOiIzZmExYjFmOThhYTUyMDFjOTUxZTFjZTg0YTQ1MGFkYjgzNjVjZmRlY2QzM2EyMTUxMmMwZjc2ZDY1NDU0N2QxIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:10 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETestado-resultados-export" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETestado-resultados-export"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETestado-resultados-export"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETestado-resultados-export" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETestado-resultados-export">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETestado-resultados-export" data-method="GET"
      data-path="estado-resultados/export"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETestado-resultados-export', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>estado-resultados/export</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETestado-resultados-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETestado-resultados-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="GETestado-resultados-export"
               value="17"
               data-component="query">
    <br>
<p>Año. Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="GETestado-resultados-export"
               value="17"
               data-component="query">
    <br>
<p>ID del almacén (opcional). Example: <code>17</code></p>
            </div>
                </form>

                    <h2 id="estado-de-resultados-POSTestado-resultados-store">Guardar registro ER manual</h2>

<p>
</p>

<p>Guarda un registro individual en el Estado de Resultados.
Útil para captura manual de datos cuando no se dispone de archivo.</p>

<span id="example-requests-POSTestado-resultados-store">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/estado-resultados/store" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"almacen_id\": 17,
    \"concepto_id\": 17,
    \"anio\": 17,
    \"mes\": 17,
    \"monto\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/estado-resultados/store"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "almacen_id": 17,
    "concepto_id": 17,
    "anio": 17,
    "mes": 17,
    "monto": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTestado-resultados-store">
</span>
<span id="execution-results-POSTestado-resultados-store" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTestado-resultados-store"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTestado-resultados-store"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTestado-resultados-store" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTestado-resultados-store">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTestado-resultados-store" data-method="POST"
      data-path="estado-resultados/store"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTestado-resultados-store', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>estado-resultados/store</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTestado-resultados-store"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTestado-resultados-store"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="POSTestado-resultados-store"
               value="17"
               data-component="body">
    <br>
<p>ID del almacén. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>concepto_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="concepto_id"                data-endpoint="POSTestado-resultados-store"
               value="17"
               data-component="body">
    <br>
<p>ID del concepto maestro (categoría ER). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTestado-resultados-store"
               value="17"
               data-component="body">
    <br>
<p>Año (2000-2100). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mes</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mes"                data-endpoint="POSTestado-resultados-store"
               value="17"
               data-component="body">
    <br>
<p>Mes (1-12). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>monto</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="monto"                data-endpoint="POSTestado-resultados-store"
               value="consequatur"
               data-component="body">
    <br>
<p>Monto del registro. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="estado-de-resultados-POSTestado-resultados-import-pdf">Importar Estado de Resultados desde PDF</h2>

<p>
</p>

<p>Procesa un PDF de Estado de Resultados, extrayendo valores reales
para los conceptos TOTAL GTOS DE DISTRIBUCION y RESULTADO DIRECTO DE OPERACIÓN.
Detecta automáticamente el mes y almacén.</p>

<span id="example-requests-POSTestado-resultados-import-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/estado-resultados/import-pdf" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "anio=17"\
    --form "archivo_pdf=@C:\Users\qange\AppData\Local\Temp\php31FE.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/estado-resultados/import-pdf"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('anio', '17');
body.append('archivo_pdf', document.querySelector('input[name="archivo_pdf"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTestado-resultados-import-pdf">
</span>
<span id="execution-results-POSTestado-resultados-import-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTestado-resultados-import-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTestado-resultados-import-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTestado-resultados-import-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTestado-resultados-import-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTestado-resultados-import-pdf" data-method="POST"
      data-path="estado-resultados/import-pdf"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTestado-resultados-import-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>estado-resultados/import-pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTestado-resultados-import-pdf"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTestado-resultados-import-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo_pdf</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo_pdf"                data-endpoint="POSTestado-resultados-import-pdf"
               value=""
               data-component="body">
    <br>
<p>Archivo PDF hasta 100MB. Example: <code>C:\Users\qange\AppData\Local\Temp\php31FE.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTestado-resultados-import-pdf"
               value="17"
               data-component="body">
    <br>
<p>Año (2000-2100). Example: <code>17</code></p>
        </div>
        </form>

                <h1 id="importaciones">Importaciones</h1>

    

                                <h2 id="importaciones-GETimportaciones">Mostrar centro de importación</h2>

<p>
</p>

<p>Renderiza la página principal con todos los formularios de importación:
comprometidos (ER, Mermas) y realizados (Ventas, PDF, Surtimiento, Mermas).</p>

<span id="example-requests-GETimportaciones">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/importaciones" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETimportaciones">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=utf-8
cache-control: no-cache, private
set-cookie: XSRF-TOKEN=eyJpdiI6IndkVUFuQnIzMEVWR1BZNTFwS1pqNXc9PSIsInZhbHVlIjoiM1ZHRjB0NitwdEJYZDhINnhiMVFDMTNocFZsUDZJaVduV1NBS28xeElva3ovSDF3TG8vK0hobHkvVWNyZVY3MTcyWmtwU01CSVV6WVVFM1daSURJc2t6Y1Avd2JqWE0vTXdVaCtSUGEyS0oyZFJqN09NandCTXkwc1VhNWR1aUUiLCJtYWMiOiIxOTZhMDE3ZTVkMDllOTc4ODZmYzU5NmY1NWQ0NGVjODg1MmJiOWRiNzNkNDBiMWE1M2UwZmIxNTk2Zjc3NGI3IiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:08 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6ImpXUk1xc0RSZXRQWE84YjZtWVBnVFE9PSIsInZhbHVlIjoidkxKenVNSThPTGtYMmtRS3kzY2xDTFBWQlduNTkzNGNwWXhrUXBMQnUzZXM5c05yNXRwcEJDSitzaytSUXNSTWV0TDlFZmVjQUJUVGZsaTN0NzVnbVBIdzlHQS9pcnJwV0lMb1pTUFArVnBTbS96WnpkR2VVaUJYRmpIZXRkdWMiLCJtYWMiOiI3MmM0NTRmODFlMGJiNWEwZWQxODdhZjUyOTU5MGVjZjA1NGUxNGE0MWNlMmE5ZmJiOTkxOTAzOWEzNGIxNjllIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:08 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;

&lt;head&gt;

    
    &lt;meta charset=&quot;utf-8&quot;&gt;
    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;
    &lt;meta name=&quot;csrf-token&quot; content=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot;&gt;

    
        &lt;link rel=&quot;icon&quot; type=&quot;image/png&quot; href=&quot;http://localhost/brand-icon.png?v=5&quot;&gt;

    
    &lt;title&gt;
                Centro de Importaci&oacute;n            &lt;/title&gt;

    
    &lt;!-- IFrame Preloader Removal Workaround --&gt;
    &lt;style type=&quot;text/css&quot;&gt;
        body.iframe-mode .preloader {
            display: none !important;
        }
    &lt;/style&gt;

    
    
    
                            &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/vendor/fontawesome-free/css/all.min.css&quot;&gt;
                &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/vendor/overlayScrollbars/css/OverlayScrollbars.min.css&quot;&gt;
                &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/vendor/adminlte/dist/css/adminlte.min.css&quot;&gt;

                                    &lt;link rel=&quot;stylesheet&quot; href=&quot;https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&quot;&gt;
                            
    
    &lt;link rel=&quot;stylesheet&quot; href=&quot;//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css&quot;&gt;
            
            

    

    
    

    

    

    
    

    

    

    
    

    

    

    
    

            
            

            
            

                            &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/css/variables-institucionales.css&quot;&gt;
            
            

    
    
    
            &lt;link rel=&quot;preload&quot; as=&quot;style&quot; href=&quot;http://localhost/build/assets/importaciones-Ddo0Swuo.css&quot; /&gt;&lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/build/assets/importaciones-Ddo0Swuo.css&quot; data-navigate-track=&quot;reload&quot; /&gt;
    
    
&lt;/head&gt;

&lt;body class=&quot;sidebar-mini&quot; &gt;

    
        &lt;div class=&quot;wrapper&quot;&gt;

        
                    &lt;div class=&quot;preloader flex-column justify-content-center align-items-center&quot; style=&quot;&quot;&gt;

    
        
        &lt;img src=&quot;http://localhost/img/logos/logoAlimentacionBienestar1.png&quot;
             class=&quot;img-circle animation__shake&quot;
             alt=&quot;POA Preloader Image&quot;
             width=&quot;60&quot;
             height=&quot;60&quot;
             style=&quot;animation-iteration-count:infinite;&quot;&gt;

    
&lt;/div&gt;
        
        
                    &lt;nav class=&quot;main-header navbar
    navbar-expand
    navbar-white navbar-light&quot;&gt;

    
    &lt;ul class=&quot;navbar-nav&quot;&gt;
        
        &lt;li class=&quot;nav-item&quot;&gt;
    &lt;a class=&quot;nav-link&quot; data-widget=&quot;pushmenu&quot; href=&quot;#&quot;
                        &gt;
        &lt;i class=&quot;fas fa-bars&quot;&gt;&lt;/i&gt;
        &lt;span class=&quot;sr-only&quot;&gt;Toggle navigation&lt;/span&gt;
    &lt;/a&gt;
&lt;/li&gt;
        
        
        
            &lt;img src=&quot;/img/logos/logoAlimentacionBienestar.png&quot; style=&quot;height: 33px; margin-top: 5px; margin-left: 10px;&quot;&gt;
    &lt;/ul&gt;

    
    &lt;ul class=&quot;navbar-nav ml-auto&quot;&gt;
        
            &lt;img src=&quot;/img/logos/gobierno.png&quot; style=&quot;height: 33px; margin-top: 5px; margin-right: 10px;&quot;&gt;

        
        
        
        
        
            &lt;/ul&gt;

&lt;/nav&gt;
        
        
                    &lt;aside class=&quot;main-sidebar sidebar-dark-primary elevation-4&quot;&gt;

    
            &lt;a href=&quot;http://localhost/home&quot;
            class=&quot;brand-link &quot;
    &gt;

    
    &lt;img src=&quot;http://localhost/img/logos/logoAlimentacionBienestar1.png&quot;
         alt=&quot;POA Logo&quot;
         class=&quot;brand-image img-circle elevation-3&quot;
         style=&quot;opacity:.8&quot;&gt;

    
    &lt;span class=&quot;brand-text font-weight-light &quot;&gt;
        &lt;b&gt;POA&lt;/b&gt; Bienestar
    &lt;/span&gt;

&lt;/a&gt;
    
    
    &lt;div class=&quot;sidebar&quot;&gt;
        &lt;nav class=&quot;pt-2&quot;&gt;
            &lt;ul class=&quot;nav nav-pills nav-sidebar flex-column &quot;
                data-widget=&quot;treeview&quot; role=&quot;menu&quot;
                                &gt;
                
                &lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link active &quot;
       href=&quot;http://localhost&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-tachometer-alt &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Dashboard

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/importaciones&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-file-import &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Centro de Importaci&oacute;n

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/estado-resultados&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-chart-line &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Estado de Resultados

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/poa&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-bullseye &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Formato POA

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-header &quot;&gt;

    ACCOUNT SETTINGS

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/admin/settings&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-user &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Profile

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

&lt;li  class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link  &quot;
       href=&quot;http://localhost/admin/settings&quot;        &gt;

        &lt;i class=&quot;nav-icon fas fa-fw fa-lock &quot;&gt;&lt;/i&gt;

        &lt;p&gt;
            Change Password

                    &lt;/p&gt;

    &lt;/a&gt;

&lt;/li&gt;

            &lt;/ul&gt;
        &lt;/nav&gt;
    &lt;/div&gt;

&lt;/aside&gt;
        
        
                    &lt;div class=&quot;content-wrapper&quot;&gt;

    
    
    
            &lt;div class=&quot;content-header&quot;&gt;
            &lt;div class=&quot;container-fluid&quot;&gt;
                &lt;h1&gt;&lt;i class=&quot;fas fa-file-import text-institucional-oro&quot;&gt;&lt;/i&gt; Centro de Importaci&oacute;n Homologado&lt;/h1&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    
    
    &lt;div class=&quot;content&quot;&gt;
        &lt;div class=&quot;container-fluid&quot;&gt;
                        &lt;div id=&quot;loading-overlay&quot; class=&quot;import-loading-overlay&quot;&gt;
    &lt;div class=&quot;spinner&quot;&gt;&lt;/div&gt;
    &lt;p&gt;&lt;i class=&quot;fas fa-process&quot;&gt;&lt;/i&gt; Procesando archivo, por favor espera...&lt;/p&gt;
&lt;/div&gt;



&lt;!-- ==================== SECCI&Oacute;N: COMPROMETIDOS ==================== --&gt;
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-12 mb-3&quot;&gt;
        &lt;div class=&quot;section-divider&quot;&gt;
            &lt;span class=&quot;section-divider-icon&quot;&gt;&lt;i class=&quot;fas fa-bullseye&quot;&gt;&lt;/i&gt;&lt;/span&gt;
            &lt;span class=&quot;section-divider-text&quot;&gt;COMPROMETIDOS (META)&lt;/span&gt;
            &lt;span class=&quot;section-divider-sub&quot;&gt;Conceptos 1 al 5 y 8&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class=&quot;col-xl-4 col-lg-4 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-chart-line&quot;&gt;&lt;/i&gt; Estado de Resultados&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;COMPROMETIDO (Conc. 1 al 5)&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/er&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o fiscal&lt;/label&gt;
                &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
            &lt;/div&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;Archivo Excel&lt;/label&gt;
                &lt;label for=&quot;archivo-er&quot; class=&quot;upload-area&quot; id=&quot;zone-upload-er&quot; style=&quot;display: block;&quot;&gt;
                    &lt;i class=&quot;fas fa-file-excel fa-2x text-muted mb-2&quot;&gt;&lt;/i&gt;
                    &lt;p class=&quot;mb-1&quot;&gt;Arrastra el archivo o haz clic para seleccionar&lt;/p&gt;
                    &lt;small class=&quot;text-muted&quot;&gt;Formatos: Excel (.xlsx, .xls, .csv)&lt;/small&gt;
                &lt;/label&gt;
                &lt;input type=&quot;file&quot; name=&quot;archivo&quot; id=&quot;archivo-er&quot; accept=&quot;.xlsx,.xls,.csv&quot; style=&quot;display:none&quot; required&gt;
                &lt;div id=&quot;filename-er&quot; class=&quot;mt-2 text-muted small&quot;&gt;&lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-chart-line&quot;&gt;&lt;/i&gt;
                Importa el presupuesto desde el Excel de Estado de Resultados. Alimenta el &lt;strong&gt;COMPROMETIDO&lt;/strong&gt; de los conceptos 1 al 5 del POA.
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-upload&quot;&gt;&lt;/i&gt; Importar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;    &lt;/div&gt;

    &lt;div class=&quot;col-xl-4 col-lg-4 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-orange&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-weight-hanging&quot;&gt;&lt;/i&gt; Mermas, Quebrantos y Mal Estado&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;COMPROMETIDO (Conc. 8)&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/mermas&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o&lt;/label&gt;
                &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
            &lt;/div&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;Archivo Excel&lt;/label&gt;
                &lt;label for=&quot;archivo-mermas&quot; class=&quot;upload-area upload-area-orange&quot; id=&quot;zone-upload-mermas&quot; style=&quot;display: block;&quot;&gt;
                    &lt;i class=&quot;fas fa-file-excel fa-2x text-muted mb-2&quot;&gt;&lt;/i&gt;
                    &lt;p class=&quot;mb-1&quot;&gt;Arrastra el archivo o haz clic aqu&iacute;&lt;/p&gt;
                    &lt;small class=&quot;text-muted&quot;&gt;Formatos: Excel (.xlsx, .xls)&lt;/small&gt;
                &lt;/label&gt;
                &lt;input type=&quot;file&quot; name=&quot;archivo&quot; id=&quot;archivo-mermas&quot; accept=&quot;.xlsx,.xls&quot; style=&quot;display:none&quot; required&gt;
                &lt;div id=&quot;filename-mermas&quot; class=&quot;mt-2 text-muted small&quot;&gt;&lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-calculator&quot;&gt;&lt;/i&gt;
                Calcula el comprometido de mermas a partir de las ventas por l&iacute;nea y porcentajes configurados. Alimenta el &lt;strong&gt;COMPROMETIDO&lt;/strong&gt; del concepto 8.
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-upload&quot;&gt;&lt;/i&gt; Importar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;

    &lt;/div&gt;

    &lt;div class=&quot;col-xl-4 col-lg-4 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-store&quot;&gt;&lt;/i&gt; Apertura de Tiendas&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;COMPROMETIDO (Conc. 33, 34, 35)&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/apertura-tiendas&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o&lt;/label&gt;
                &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
            &lt;/div&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;Archivo Excel (Anexo 4)&lt;/label&gt;
                &lt;label for=&quot;archivo-apertura&quot; class=&quot;upload-area&quot; id=&quot;zone-upload-apertura&quot; style=&quot;display: block;&quot;&gt;
                    &lt;i class=&quot;fas fa-file-excel fa-2x text-muted mb-2&quot;&gt;&lt;/i&gt;
                    &lt;p class=&quot;mb-1&quot;&gt;Arrastra el archivo o haz clic aqu&iacute;&lt;/p&gt;
                    &lt;small class=&quot;text-muted&quot;&gt;Formatos: Excel (.xlsx, .xls)&lt;/small&gt;
                &lt;/label&gt;
                &lt;input type=&quot;file&quot; name=&quot;archivo&quot; id=&quot;archivo-apertura&quot; accept=&quot;.xlsx,.xls&quot; style=&quot;display:none&quot; required&gt;
                &lt;div id=&quot;filename-apertura&quot; class=&quot;mt-2 text-muted small&quot;&gt;&lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-bullseye&quot;&gt;&lt;/i&gt;
                Importa el &lt;strong&gt;COMPROMETIDO (META)&lt;/strong&gt; de apertura de tiendas seg&uacute;n la programaci&oacute;n anual del Excel (Anexo 4).
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-upload&quot;&gt;&lt;/i&gt; Importar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- ==================== SECCI&Oacute;N: REALIZADOS ==================== --&gt;
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-12 mb-3&quot;&gt;
        &lt;div class=&quot;section-divider section-divider-real&quot;&gt;
            &lt;span class=&quot;section-divider-icon&quot;&gt;&lt;i class=&quot;fas fa-check-circle&quot;&gt;&lt;/i&gt;&lt;/span&gt;
            &lt;span class=&quot;section-divider-text&quot;&gt;REALIZADOS (REAL)&lt;/span&gt;
            &lt;span class=&quot;section-divider-sub&quot;&gt;Conceptos 1 al 8&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class=&quot;col-xl-3 col-lg-6 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-azul&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-cash-register&quot;&gt;&lt;/i&gt; Ventas por L&iacute;nea&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;REALIZADO (Conc. 1 al 3)&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/ventas&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o&lt;/label&gt;
                &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
            &lt;/div&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;Archivo Excel&lt;/label&gt;
                &lt;label for=&quot;archivo-ventas&quot; class=&quot;upload-area upload-area-azul&quot; id=&quot;zone-upload-ventas&quot; style=&quot;display: block;&quot;&gt;
                    &lt;i class=&quot;fas fa-file-excel fa-2x text-muted mb-2&quot;&gt;&lt;/i&gt;
                    &lt;p class=&quot;mb-1&quot;&gt;Arrastra el archivo o haz clic aqu&iacute;&lt;/p&gt;
                    &lt;small class=&quot;text-muted&quot;&gt;Formatos: Excel (.xlsx, .xls, .csv)&lt;/small&gt;
                &lt;/label&gt;
                &lt;input type=&quot;file&quot; name=&quot;archivo&quot; id=&quot;archivo-ventas&quot; accept=&quot;.xlsx,.xls,.csv&quot; style=&quot;display:none&quot; required&gt;
                &lt;div id=&quot;filename-ventas&quot; class=&quot;mt-2 text-muted small&quot;&gt;&lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-cash-register&quot;&gt;&lt;/i&gt;
                Importa las ventas del programa &lt;strong&gt;ABASTO RURAL (PAR)&lt;/strong&gt; y &lt;strong&gt;Programas Especiales (PE)&lt;/strong&gt;. Alimenta el &lt;strong&gt;REALIZADO&lt;/strong&gt; de los conceptos 1 al 3.
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-upload&quot;&gt;&lt;/i&gt; Importar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;    &lt;/div&gt;

    &lt;div class=&quot;col-xl-3 col-lg-6 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-indigo&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-file-pdf&quot;&gt;&lt;/i&gt; Ejecuci&oacute;n Real (PDF)&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;REALIZADO (Conc. 4 y 5)&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/pdf-realizado&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o&lt;/label&gt;
                &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
            &lt;/div&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;Archivo PDF&lt;/label&gt;
                &lt;label for=&quot;archivo-pdf&quot; class=&quot;upload-area upload-area-indigo&quot; id=&quot;zone-upload-pdf&quot; style=&quot;display: block;&quot;&gt;
                    &lt;i class=&quot;fas fa-file-pdf fa-2x text-muted mb-2&quot;&gt;&lt;/i&gt;
                    &lt;p class=&quot;mb-1&quot;&gt;Arrastra el archivo o haz clic aqu&iacute;&lt;/p&gt;
                    &lt;small class=&quot;text-muted&quot;&gt;Formato: PDF (.pdf)&lt;/small&gt;
                &lt;/label&gt;
                &lt;input type=&quot;file&quot; name=&quot;archivo&quot; id=&quot;archivo-pdf&quot; accept=&quot;.pdf&quot; style=&quot;display:none&quot; required&gt;
                &lt;div id=&quot;filename-pdf&quot; class=&quot;mt-2 text-muted small&quot;&gt;&lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-file-pdf&quot;&gt;&lt;/i&gt;
                Extrae autom&aacute;ticamente los montos de &lt;strong&gt;Resultado Directo de Operaci&oacute;n&lt;/strong&gt; y &lt;strong&gt;Gastos de Distribuci&oacute;n&lt;/strong&gt; del PDF. Alimenta el &lt;strong&gt;REALIZADO&lt;/strong&gt; de los conceptos 4 y 5.
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-upload&quot;&gt;&lt;/i&gt; Importar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;
    &lt;/div&gt;

    &lt;div class=&quot;col-xl-3 col-lg-6 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-teal&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-percentage&quot;&gt;&lt;/i&gt; Surtimiento a Tiendas&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;REALIZADO (Conc. 6 y 7)&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/surtimiento&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o&lt;/label&gt;
                &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
            &lt;/div&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label class=&quot;font-weight-bold&quot;&gt;Archivo Excel&lt;/label&gt;
                &lt;label for=&quot;archivo-surtimiento&quot; class=&quot;upload-area upload-area-teal&quot; id=&quot;zone-upload-surt&quot; style=&quot;display: block;&quot;&gt;
                    &lt;i class=&quot;fas fa-file-excel fa-2x text-muted mb-2&quot;&gt;&lt;/i&gt;
                    &lt;p class=&quot;mb-1&quot;&gt;Arrastra el archivo o haz clic aqu&iacute;&lt;/p&gt;
                    &lt;small class=&quot;text-muted&quot;&gt;Formatos: Excel (.xlsx, .xls)&lt;/small&gt;
                &lt;/label&gt;
                &lt;input type=&quot;file&quot; name=&quot;archivo&quot; id=&quot;archivo-surtimiento&quot; accept=&quot;.xlsx,.xls&quot; style=&quot;display:none&quot; required&gt;
                &lt;div id=&quot;filename-surt&quot; class=&quot;mt-2 text-muted small&quot;&gt;&lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-percentage&quot;&gt;&lt;/i&gt;
                Importa &lt;strong&gt;Oportunidad&lt;/strong&gt; y &lt;strong&gt;Eficiencia de Surtimiento&lt;/strong&gt; a Tiendas desde el archivo CONS. Alimenta el &lt;strong&gt;REALIZADO&lt;/strong&gt; de los conceptos 6 y 7.
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-upload&quot;&gt;&lt;/i&gt; Importar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;
    &lt;/div&gt;

    &lt;div class=&quot;col-xl-3 col-lg-6 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-danger&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-hand-holding-usd&quot;&gt;&lt;/i&gt; Mermas, Quebrantos y Mal Estado&lt;/h3&gt;
        &lt;span class=&quot;badge bg-white text-secondary font-weight-bold&quot; style=&quot;font-size:0.7rem;&quot;&gt;REALIZADO (Conc. 8) &mdash; Por Trimestre&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body d-flex flex-column&quot;&gt;
        &lt;form action=&quot;http://localhost/importaciones/mermas-comprometido&quot; method=&quot;POST&quot; class=&quot;d-flex flex-column flex-fill&quot;&gt;
            &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;l9NIfOY5uciiEKVW7lcgb9K9bEgfoxAotpEXtUwe&quot; autocomplete=&quot;off&quot;&gt;            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label class=&quot;font-weight-bold&quot;&gt;Almac&eacute;n&lt;/label&gt;
                        &lt;select name=&quot;almacen_id&quot; class=&quot;form-control&quot; required&gt;
                            &lt;option value=&quot;&quot;&gt;Almac&eacute;n...&lt;/option&gt;
                                                            &lt;option value=&quot;1&quot;&gt;ALMACEN CENTRAL OAXACA&lt;/option&gt;
                                                            &lt;option value=&quot;2&quot;&gt;AYUTLA MIXES&lt;/option&gt;
                                                            &lt;option value=&quot;3&quot;&gt;CUAJIMOLOYAS&lt;/option&gt;
                                                            &lt;option value=&quot;5&quot;&gt;IXTLAN DE JUAREZ&lt;/option&gt;
                                                            &lt;option value=&quot;7&quot;&gt;LACHIXIO&lt;/option&gt;
                                                            &lt;option value=&quot;9&quot;&gt;MAGDALENA OCOTLAN&lt;/option&gt;
                                                            &lt;option value=&quot;10&quot;&gt;SAN ANDRES HIDALGO&lt;/option&gt;
                                                            &lt;option value=&quot;4&quot;&gt;SAN JOSE EL CHILAR&lt;/option&gt;
                                                            &lt;option value=&quot;6&quot;&gt;SAN PEDRO JUCHATENGO&lt;/option&gt;
                                                            &lt;option value=&quot;8&quot;&gt;SANTIAGO MATATLAN&lt;/option&gt;
                                                            &lt;option value=&quot;11&quot;&gt;SANTIAGO TEOTITLAN&lt;/option&gt;
                                                            &lt;option value=&quot;12&quot;&gt;TAMAZULAPAN&lt;/option&gt;
                                                            &lt;option value=&quot;13&quot;&gt;VALLES CENTRALES&lt;/option&gt;
                                                    &lt;/select&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label class=&quot;font-weight-bold&quot;&gt;A&ntilde;o&lt;/label&gt;
                        &lt;input type=&quot;number&quot; name=&quot;anio&quot; class=&quot;form-control&quot; value=&quot;2026&quot; min=&quot;2000&quot; max=&quot;2100&quot; required&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label class=&quot;font-weight-bold&quot;&gt;Trimestre&lt;/label&gt;
                        &lt;select name=&quot;trimestre&quot; class=&quot;form-control&quot; required&gt;
                            &lt;option value=&quot;&quot;&gt;Trime...&lt;/option&gt;
                            &lt;option value=&quot;1&quot;&gt;Q1&lt;/option&gt;
                            &lt;option value=&quot;2&quot;&gt;Q2&lt;/option&gt;
                            &lt;option value=&quot;3&quot;&gt;Q3&lt;/option&gt;
                            &lt;option value=&quot;4&quot;&gt;Q4&lt;/option&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label class=&quot;font-weight-bold&quot;&gt;Monto&lt;/label&gt;
                        &lt;input type=&quot;number&quot; name=&quot;monto&quot; class=&quot;form-control&quot; step=&quot;0.01&quot; lang=&quot;en&quot; placeholder=&quot;0.00&quot; required&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;alert alert-guinda small mt-1&quot;&gt;
                &lt;i class=&quot;fas fa-hand-holding-usd&quot;&gt;&lt;/i&gt;
                El valor trimestral se distribuir&aacute; en partes iguales entre los 3 meses del trimestre seleccionado. Alimenta el &lt;strong&gt;REALIZADO&lt;/strong&gt; del concepto 8.
            &lt;/div&gt;
            &lt;button type=&quot;submit&quot; class=&quot;btn btn-oro btn-import btn-block mt-auto&quot;&gt;
                &lt;i class=&quot;fas fa-save&quot;&gt;&lt;/i&gt; Guardar
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;

    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;
    &lt;!-- BLOQUE 4: INFO / ESTADO POA --&gt;
    &lt;div class=&quot;col-lg-8 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-poa&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-info-circle&quot;&gt;&lt;/i&gt; Instrucciones de Uso&lt;/h3&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;h5&gt;Estado de Resultados&lt;/h5&gt;
        &lt;ul&gt;
            &lt;li&gt;Sube el archivo Excel del Estado de Resultados con la estructura est&aacute;ndar.&lt;/li&gt;
            &lt;li&gt;El sistema identificar&aacute; el almac&eacute;n y la unidad operativa autom&aacute;ticamente.&lt;/li&gt;
            &lt;li&gt;Los datos se guardar&aacute;n en la base de datos.&lt;/li&gt;
            &lt;li&gt;&lt;strong&gt;La sincronizaci&oacute;n con POA es autom&aacute;tica tras importar.&lt;/strong&gt;&lt;/li&gt;
        &lt;/ul&gt;
        &lt;h5 class=&quot;mt-3&quot;&gt;Formato POA&lt;/h5&gt;
        &lt;ul&gt;
            &lt;li&gt;Accede a &quot;Formato POA&quot; para ver las metas vsrealizado.&lt;/li&gt;
            &lt;li&gt;Los datos ya est&aacute;n sincronizados del ER.&lt;/li&gt;
            &lt;li&gt;Usa los filtros para per&iacute;odo y consolidado.&lt;/li&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
&lt;/div&gt;    &lt;/div&gt;
    &lt;div class=&quot;col-lg-4 mb-4&quot;&gt;
        &lt;div class=&quot;card import-card import-card-poa&quot;&gt;
    &lt;div class=&quot;card-header d-flex justify-content-between align-items-center&quot;&gt;
        &lt;h3 class=&quot;card-title&quot;&gt;&lt;i class=&quot;fas fa-bullseye&quot;&gt;&lt;/i&gt; Metas POA&lt;/h3&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;alert alert-info&quot;&gt;
            &lt;i class=&quot;fas fa-info-circle&quot;&gt;&lt;/i&gt;
            &lt;strong&gt;Sincronizaci&oacute;n autom&aacute;tica&lt;/strong&gt;
        &lt;/div&gt;
        &lt;p class=&quot;text-muted&quot;&gt;
            Las metas POA se sincronizan autom&aacute;ticamente al importar el Estado de Resultados.
            No necesitas hacer nada extra.
        &lt;/p&gt;
        &lt;hr&gt;
        &lt;h5 class=&quot;font-weight-bold&quot;&gt;&iquest;C&oacute;mo funciona?&lt;/h5&gt;
        &lt;ol class=&quot;small text-muted&quot;&gt;
            &lt;li&gt;Importas el archivo Estado de Resultados&lt;/li&gt;
            &lt;li&gt;El sistema detecta los almacenes autom&aacute;ticamente&lt;/li&gt;
            &lt;li&gt;La sincronizaci&oacute;n POA es autom&aacute;tica&lt;/li&gt;
            &lt;li&gt;Puedes ver los resultados en &quot;Formato POA&quot;&lt;/li&gt;
        &lt;/ol&gt;
    &lt;/div&gt;
&lt;/div&gt;    &lt;/div&gt;
&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;
        
        
        
        
        
    &lt;/div&gt;

    
                            &lt;script src=&quot;http://localhost/vendor/jquery/jquery.min.js&quot;&gt;&lt;/script&gt;
                &lt;script src=&quot;http://localhost/vendor/bootstrap/js/bootstrap.bundle.min.js&quot;&gt;&lt;/script&gt;
                &lt;script src=&quot;http://localhost/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js&quot;&gt;&lt;/script&gt;
                &lt;script src=&quot;http://localhost/vendor/adminlte/dist/js/adminlte.min.js&quot;&gt;&lt;/script&gt;
            
    
    &lt;script src=&quot;//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js&quot; &gt;&lt;/script&gt;
            
        
            

            
            

            
            

    

    
    

    

    

    
    

    

    

    
    

    

    

    
    

            
            

            
            

            
            

    
    
    
        &lt;script&gt;
document.addEventListener(&#039;DOMContentLoaded&#039;, function() {
    const inputs = document.querySelectorAll(&#039;input[type=&quot;number&quot;][lang=&quot;en&quot;]&#039;);
    inputs.forEach(function(input) {
        input.addEventListener(&#039;blur&#039;, function() {
            if (this.value !== &#039;&#039;) {
                let val = this.value.replace(&#039;,&#039;, &#039;.&#039;);
                let num = parseFloat(val);
                if (!isNaN(num)) {
                    this.value = num.toFixed(2);
                }
            }
        });
    });
});
&lt;/script&gt;
    &lt;link rel=&quot;modulepreload&quot; as=&quot;script&quot; href=&quot;http://localhost/build/assets/importaciones-DxsJYjMt.js&quot; /&gt;&lt;script type=&quot;module&quot; src=&quot;http://localhost/build/assets/importaciones-DxsJYjMt.js&quot; data-navigate-track=&quot;reload&quot;&gt;&lt;/script&gt;&lt;script&gt;
    document.addEventListener(&#039;DOMContentLoaded&#039;, function () {
        const overlay = document.getElementById(&#039;loading-overlay&#039;);
        document.querySelectorAll(&#039;.import-card form&#039;).forEach(function (form) {
            form.addEventListener(&#039;submit&#039;, function () {
                overlay.classList.add(&#039;active&#039;);
            });
        });
    });
&lt;/script&gt;

&lt;/body&gt;

&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GETimportaciones" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETimportaciones"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETimportaciones"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETimportaciones" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETimportaciones">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETimportaciones" data-method="GET"
      data-path="importaciones"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETimportaciones', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>importaciones</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETimportaciones"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETimportaciones"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="importaciones-POSTimportaciones-er">Importar Estado de Resultados (Excel)</h2>

<p>
</p>

<p>Procesa un archivo Excel con múltiples hojas (una por almacén) y
guarda/actualiza los registros META de la categoría ER.
Cada hoja se procesa con ERSheetImport.</p>

<span id="example-requests-POSTimportaciones-er">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/er" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "anio=17"\
    --form "archivo=@C:\Users\qange\AppData\Local\Temp\php2982.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/er"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('anio', '17');
body.append('archivo', document.querySelector('input[name="archivo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-er">
</span>
<span id="execution-results-POSTimportaciones-er" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-er"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-er"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-er" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-er">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-er" data-method="POST"
      data-path="importaciones/er"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-er', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/er</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-er"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-er"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo"                data-endpoint="POSTimportaciones-er"
               value=""
               data-component="body">
    <br>
<p>Archivo Excel (.xlsx, .xls, .csv) hasta 100MB. Example: <code>C:\Users\qange\AppData\Local\Temp\php2982.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTimportaciones-er"
               value="17"
               data-component="body">
    <br>
<p>Año de los registros (2000-2100). Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="importaciones-POSTimportaciones-ventas">Importar ventas detalladas (Excel)</h2>

<p>
</p>

<p>Procesa un Excel con ventas detalladas por línea de producto y almacén.
Soporta dos programas: PAR (Abasto Rural) y PE (Programa Especial).
Los datos se guardan como tipo_dato=REAL con programa=PAR|PE.</p>

<span id="example-requests-POSTimportaciones-ventas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/ventas" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "programa=consequatur"\
    --form "archivo=@C:\Users\qange\AppData\Local\Temp\php2995.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/ventas"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('programa', 'consequatur');
body.append('archivo', document.querySelector('input[name="archivo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-ventas">
</span>
<span id="execution-results-POSTimportaciones-ventas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-ventas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-ventas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-ventas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-ventas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-ventas" data-method="POST"
      data-path="importaciones/ventas"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-ventas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/ventas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-ventas"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-ventas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo"                data-endpoint="POSTimportaciones-ventas"
               value=""
               data-component="body">
    <br>
<p>Archivo Excel (.xlsx, .xls, .csv) hasta 100MB. Example: <code>C:\Users\qange\AppData\Local\Temp\php2995.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>programa</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="programa"                data-endpoint="POSTimportaciones-ventas"
               value="consequatur"
               data-component="body">
    <br>
<p>Programa: "PAR" para Abasto Rural, "PE" para Programa Especial. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="importaciones-POSTimportaciones-pdf-realizado">Importar realizado desde PDF</h2>

<p>
</p>

<p>Extrae datos reales de un PDF de Estado de Resultados.
Detecta automáticamente el mes y escala valores (miles → pesos).
Procesa dos bloques de tiendas y conceptos como TOTAL GTOS DE DISTRIBUCION
y RESULTADO DIRECTO DE OPERACIÓN.</p>

<span id="example-requests-POSTimportaciones-pdf-realizado">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/pdf-realizado" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "anio=17"\
    --form "archivo=@C:\Users\qange\AppData\Local\Temp\php29A7.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/pdf-realizado"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('anio', '17');
body.append('archivo', document.querySelector('input[name="archivo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-pdf-realizado">
</span>
<span id="execution-results-POSTimportaciones-pdf-realizado" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-pdf-realizado"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-pdf-realizado"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-pdf-realizado" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-pdf-realizado">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-pdf-realizado" data-method="POST"
      data-path="importaciones/pdf-realizado"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-pdf-realizado', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/pdf-realizado</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-pdf-realizado"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-pdf-realizado"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo"                data-endpoint="POSTimportaciones-pdf-realizado"
               value=""
               data-component="body">
    <br>
<p>Archivo PDF hasta 100MB. Example: <code>C:\Users\qange\AppData\Local\Temp\php29A7.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTimportaciones-pdf-realizado"
               value="17"
               data-component="body">
    <br>
<p>Año de los registros (2000-2100). Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="importaciones-POSTimportaciones-surtimiento">Importar surtimiento a tiendas (Excel)</h2>

<p>
</p>

<p>Procesa el archivo "CONS 2026.xlsx" con columnas de Oportunidad y Eficiencia
por trimestre (Q1-Q4). Distribuye el valor trimestral en 3 meses.
Guarda registros REAL para los conceptos de Oportunidad y Eficiencia de Surtimiento.</p>

<span id="example-requests-POSTimportaciones-surtimiento">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/surtimiento" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "anio=17"\
    --form "archivo=@C:\Users\qange\AppData\Local\Temp\php29BA.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/surtimiento"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('anio', '17');
body.append('archivo', document.querySelector('input[name="archivo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-surtimiento">
</span>
<span id="execution-results-POSTimportaciones-surtimiento" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-surtimiento"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-surtimiento"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-surtimiento" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-surtimiento">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-surtimiento" data-method="POST"
      data-path="importaciones/surtimiento"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-surtimiento', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/surtimiento</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-surtimiento"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-surtimiento"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo"                data-endpoint="POSTimportaciones-surtimiento"
               value=""
               data-component="body">
    <br>
<p>Archivo Excel (.xlsx, .xls) hasta 100MB. Example: <code>C:\Users\qange\AppData\Local\Temp\php29BA.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTimportaciones-surtimiento"
               value="17"
               data-component="body">
    <br>
<p>Año de los registros (2000-2100). Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="importaciones-POSTimportaciones-mermas">Importar mermas y quebrantos (Excel)</h2>

<p>
</p>

<p>Procesa Excel con pestañas por almacén (ej. "PT AYUTLA").
Calcula el monto comprometido (META) aplicando tasas de merma+quebranto
sobre las ventas de cada línea de producto (config/mermas.php).</p>

<span id="example-requests-POSTimportaciones-mermas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/mermas" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "anio=17"\
    --form "archivo=@C:\Users\qange\AppData\Local\Temp\php29BD.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/mermas"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('anio', '17');
body.append('archivo', document.querySelector('input[name="archivo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-mermas">
</span>
<span id="execution-results-POSTimportaciones-mermas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-mermas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-mermas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-mermas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-mermas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-mermas" data-method="POST"
      data-path="importaciones/mermas"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-mermas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/mermas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-mermas"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-mermas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo"                data-endpoint="POSTimportaciones-mermas"
               value=""
               data-component="body">
    <br>
<p>Archivo Excel (.xlsx, .xls) hasta 100MB. Example: <code>C:\Users\qange\AppData\Local\Temp\php29BD.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTimportaciones-mermas"
               value="17"
               data-component="body">
    <br>
<p>Año de los registros (2000-2100). Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="importaciones-POSTimportaciones-mermas-comprometido">Guardar mermas realizadas (formulario manual)</h2>

<p>
</p>

<p>Registro manual de REALIZADO de Mermas, Quebrantos y Mal Estado.
Recibe un monto trimestral y lo distribuye uniformemente en 3 meses,
ajustando el último mes para cuadrar centavos.</p>

<span id="example-requests-POSTimportaciones-mermas-comprometido">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/mermas-comprometido" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"almacen_id\": 17,
    \"anio\": 17,
    \"trimestre\": 17,
    \"monto\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/mermas-comprometido"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "almacen_id": 17,
    "anio": 17,
    "trimestre": 17,
    "monto": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-mermas-comprometido">
</span>
<span id="execution-results-POSTimportaciones-mermas-comprometido" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-mermas-comprometido"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-mermas-comprometido"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-mermas-comprometido" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-mermas-comprometido">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-mermas-comprometido" data-method="POST"
      data-path="importaciones/mermas-comprometido"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-mermas-comprometido', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/mermas-comprometido</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-mermas-comprometido"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-mermas-comprometido"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="POSTimportaciones-mermas-comprometido"
               value="17"
               data-component="body">
    <br>
<p>ID del almacén. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTimportaciones-mermas-comprometido"
               value="17"
               data-component="body">
    <br>
<p>Año (2000-2100). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>trimestre</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="trimestre"                data-endpoint="POSTimportaciones-mermas-comprometido"
               value="17"
               data-component="body">
    <br>
<p>Trimestre (1-4). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>monto</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="monto"                data-endpoint="POSTimportaciones-mermas-comprometido"
               value="consequatur"
               data-component="body">
    <br>
<p>Monto trimestral. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="importaciones-POSTimportaciones-apertura-tiendas">Importar apertura de tiendas (Excel)</h2>

<p>
</p>



<span id="example-requests-POSTimportaciones-apertura-tiendas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/importaciones/apertura-tiendas" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "anio=21"\
    --form "archivo=@C:\Users\qange\AppData\Local\Temp\php29CF.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/importaciones/apertura-tiendas"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('anio', '21');
body.append('archivo', document.querySelector('input[name="archivo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTimportaciones-apertura-tiendas">
</span>
<span id="execution-results-POSTimportaciones-apertura-tiendas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTimportaciones-apertura-tiendas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTimportaciones-apertura-tiendas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTimportaciones-apertura-tiendas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTimportaciones-apertura-tiendas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTimportaciones-apertura-tiendas" data-method="POST"
      data-path="importaciones/apertura-tiendas"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTimportaciones-apertura-tiendas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>importaciones/apertura-tiendas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTimportaciones-apertura-tiendas"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTimportaciones-apertura-tiendas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>archivo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="archivo"                data-endpoint="POSTimportaciones-apertura-tiendas"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Must not be greater than 102400 kilobytes. Example: <code>C:\Users\qange\AppData\Local\Temp\php29CF.tmp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTimportaciones-apertura-tiendas"
               value="21"
               data-component="body">
    <br>
<p>Must be at least 2000. Must not be greater than 2100. Example: <code>21</code></p>
        </div>
        </form>

                <h1 id="poa">POA</h1>

    

                                <h2 id="poa-GETpoa">Mostrar POA</h2>

<p>
</p>

<p>Renderiza la tabla del Programa Anual de Trabajo con filtros por
almacén, año, período (mensual/trimestral/anual). Soporta consolidado
(todas las tiendas) o vista individual por almacén.
Si la petición es AJAX, devuelve solo el HTML de la tabla.</p>

<span id="example-requests-GETpoa">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/poa?anio=17&amp;almacen_id=17&amp;consolidado=consequatur&amp;periodo=consequatur&amp;mes=17&amp;trimestre=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/poa"
);

const params = {
    "anio": "17",
    "almacen_id": "17",
    "consolidado": "consequatur",
    "periodo": "consequatur",
    "mes": "17",
    "trimestre": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETpoa">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
set-cookie: XSRF-TOKEN=eyJpdiI6ImVyT2dBV2VMeHNvRjdFTDgwV250enc9PSIsInZhbHVlIjoiWi9hbUY5MlRUSHAvYStIQk8zMURuUmtBSlluMGpBZnFxdjZ4eG4rcFpFb25JYy9aaWZDaytENzhNcFJPN1RpaVpzam1PcEI5SWNJUVpvcnEzQ21wQzJ5RjNTZmlIejE0ejg1Um14YllSdmQyM1VaRmwyUVBkN001Ung1Rm1jOW0iLCJtYWMiOiI2OWY0ZTZkMjQwN2I0NWYwNjUzZTVhMzczMWJhODMwMmM1Y2VjYjlmNTE2NmNjNTMzYThkZjBlYmIxN2Q0NmExIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:11 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6InVydk9KNGhlZnhuTW4wK2hLZGJLQVE9PSIsInZhbHVlIjoiWm9uWGVwWUo2ZWhMUWZWNnoxQ1g2b0d5RzFGbHpzOFVQL09MK2wvMnp1cFZXN08ySjNpMEV0b2JieFFBZFMrdml1OEFDSUxBemJmUklsbXcvck81UmQ4a3c5TmhJVFFDQno3QWJWalM3aTVYZTFIeHpVam04SWcyQm1acnZiVEgiLCJtYWMiOiIwNGJlZjc3YTMyOGEyODJkYTQwMDJiZjg3NDNkYjU4NGUxZDllODZiZTQ0OWU1NThkY2U1ZjI1YjRmNzczOWRjIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:11 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETpoa" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETpoa"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETpoa"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETpoa" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETpoa">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETpoa" data-method="GET"
      data-path="poa"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETpoa', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>poa</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETpoa"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETpoa"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="GETpoa"
               value="17"
               data-component="query">
    <br>
<p>Año (default: año actual). Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="GETpoa"
               value="17"
               data-component="query">
    <br>
<p>ID del almacén (opcional, para vista individual). Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>consolidado</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="consolidado"                data-endpoint="GETpoa"
               value="consequatur"
               data-component="query">
    <br>
<p>"si" o "no" (default: "si"). Example: <code>consequatur</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>periodo</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="periodo"                data-endpoint="GETpoa"
               value="consequatur"
               data-component="query">
    <br>
<p>"mensual", "trimestral" o "anual" (default: "mensual"). Example: <code>consequatur</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>mes</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mes"                data-endpoint="GETpoa"
               value="17"
               data-component="query">
    <br>
<p>Mes (1-12, default: mes actual). Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>trimestre</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="trimestre"                data-endpoint="GETpoa"
               value="17"
               data-component="query">
    <br>
<p>Trimestre (1-4). Example: <code>17</code></p>
            </div>
                </form>

                    <h2 id="poa-GETpoa-export">Exportar POA (Excel/PDF)</h2>

<p>
</p>

<p>Descarga el POA en formato Excel (.xlsx) con plantilla predefinida
o PDF. Incluye metas comprometidas, realizadas, avance del período,
% de logro y notas aclaratorias.</p>

<span id="example-requests-GETpoa-export">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/poa/export?tipo=consequatur&amp;anio=17&amp;almacen_id=17&amp;consolidado=consequatur&amp;periodo=consequatur&amp;trimestre=17&amp;mes=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/poa/export"
);

const params = {
    "tipo": "consequatur",
    "anio": "17",
    "almacen_id": "17",
    "consolidado": "consequatur",
    "periodo": "consequatur",
    "trimestre": "17",
    "mes": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETpoa-export">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
set-cookie: XSRF-TOKEN=eyJpdiI6InU4eXFIY1V6N2Fwd082UEk2MHdIa0E9PSIsInZhbHVlIjoiczNpUDUyYjdabEJ2SEgyQjd1akJCcHdodmwxV25kVVkzTlRhU1NoSHdEdnVwU3duWFdEWWtZWEFXOCtNMisvVnhiQmU5SVEyWU42TlEvbXY1R2VHUEZWQjdUUy9XZ3paYmxKSjVLanYvZnZ4ZVlITUR1ZmlJRU0ycWlPRlM0Y1oiLCJtYWMiOiIzZDZjZDcwNDkzOGRjMzdhMTgzNDI1Njc0MGY0YjBlMDhmMzBjMzFjMzM1ZWQ4NjA3OTFlYTgyOTdkZjRkNjFlIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:11 GMT; Max-Age=7199; path=/; samesite=lax; laravel-session=eyJpdiI6IkhuYklBRW5QQnBzL21TTmM1LzhDMEE9PSIsInZhbHVlIjoiQVhnM1R4cEN1ZWsrdjJoMEhHejFXelBBSlNGRWNpNElLWE5MSkgrdTVJeE1HY0hIVDBPVjRDbTBrU3VNZVVwcE1WY1N2d2lLRXROVU14S2ZqWm0venNqUm5FMU9ObVNNb1R4a0h0RUo2V01vNjdIQ1BieUZiaDBobkp1QmtxM3AiLCJtYWMiOiJlYTUzYWU4OTViMjk2MjVmMGZiMjM5MWJmZTQ1NTIxMzU1MmQ0MzQxNTQyODdjOWFlZmVjNTA5MTBmZTQyY2NkIiwidGFnIjoiIn0%3D; expires=Mon, 18 May 2026 22:18:11 GMT; Max-Age=7199; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Tipo de exportaci&oacute;n no v&aacute;lido. Use xlsx o pdf.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETpoa-export" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETpoa-export"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETpoa-export"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETpoa-export" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETpoa-export">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETpoa-export" data-method="GET"
      data-path="poa/export"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETpoa-export', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>poa/export</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETpoa-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETpoa-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>tipo</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="tipo"                data-endpoint="GETpoa-export"
               value="consequatur"
               data-component="query">
    <br>
<p>"xlsx" o "pdf" (default: "xlsx"). Example: <code>consequatur</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="GETpoa-export"
               value="17"
               data-component="query">
    <br>
<p>Año. Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="GETpoa-export"
               value="17"
               data-component="query">
    <br>
<p>ID del almacén. Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>consolidado</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="consolidado"                data-endpoint="GETpoa-export"
               value="consequatur"
               data-component="query">
    <br>
<p>"si" o "no". Example: <code>consequatur</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>periodo</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="periodo"                data-endpoint="GETpoa-export"
               value="consequatur"
               data-component="query">
    <br>
<p>"mensual", "trimestral" o "anual". Example: <code>consequatur</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>trimestre</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="trimestre"                data-endpoint="GETpoa-export"
               value="17"
               data-component="query">
    <br>
<p>Trimestre (1-4). Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>mes</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mes"                data-endpoint="GETpoa-export"
               value="17"
               data-component="query">
    <br>
<p>Mes (1-12). Example: <code>17</code></p>
            </div>
                </form>

                    <h2 id="poa-POSTpoa-nota">Guardar nota aclaratoria</h2>

<p>
</p>

<p>Guarda o actualiza una nota aclaratoria para un concepto, almacén,
año y período específicos. Soporta notas por mes, trimestre o anual.</p>

<span id="example-requests-POSTpoa-nota">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/poa/nota" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"concepto_id\": 17,
    \"label\": \"consequatur\",
    \"anio\": 17,
    \"nota_aclaratoria\": \"consequatur\",
    \"almacen_id\": 17,
    \"mes\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/poa/nota"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "concepto_id": 17,
    "label": "consequatur",
    "anio": 17,
    "nota_aclaratoria": "consequatur",
    "almacen_id": 17,
    "mes": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTpoa-nota">
</span>
<span id="execution-results-POSTpoa-nota" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTpoa-nota"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTpoa-nota"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTpoa-nota" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTpoa-nota">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTpoa-nota" data-method="POST"
      data-path="poa/nota"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTpoa-nota', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>poa/nota</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTpoa-nota"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTpoa-nota"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>concepto_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="concepto_id"                data-endpoint="POSTpoa-nota"
               value="17"
               data-component="body">
    <br>
<p>ID del concepto maestro. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="POSTpoa-nota"
               value="consequatur"
               data-component="body">
    <br>
<p>Label de la fila (ej. "COMPROMETIDO", "REALIZADO"). Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>anio</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="anio"                data-endpoint="POSTpoa-nota"
               value="17"
               data-component="body">
    <br>
<p>Año (2000-2100). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>nota_aclaratoria</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="nota_aclaratoria"                data-endpoint="POSTpoa-nota"
               value="consequatur"
               data-component="body">
    <br>
<p>Texto de la nota (max 500 caracteres). Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>almacen_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="almacen_id"                data-endpoint="POSTpoa-nota"
               value="17"
               data-component="body">
    <br>
<p>ID del almacén (opcional, null = consolidado). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mes</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mes"                data-endpoint="POSTpoa-nota"
               value="17"
               data-component="body">
    <br>
<p>Mes del período (1-12, 101-104 para trimestre, 0 para anual). Example: <code>17</code></p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
