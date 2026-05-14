import { defineConfig } from 'vitepress'

export default defineConfig({
  lang: 'es-MX',
  title: 'POA - Documentación Técnica',
  description: 'Documentación del módulo POA - Programa Anual de Trabajo',
  lastUpdated: true,

  themeConfig: {
    logo: false,

    nav: [
      { text: 'Inicio', link: '/' },
      { text: 'Arquitectura', link: '/arquitectura/' },
      { text: 'Módulos', link: '/modulos/poa' },
      { text: 'Base de Datos', link: '/base-de-datos/esquema' },
    ],

    sidebar: {
      '/': [
        {
          text: 'Guía Rápida',
          items: [
            { text: 'Introducción', link: '/guia-rapida' },
          ],
        },
        {
          text: 'Arquitectura',
          items: [
            { text: 'Visión General', link: '/arquitectura/' },
            { text: 'Servicios de Dominio', link: '/arquitectura/domain-services' },
            { text: 'Flujo de Datos', link: '/arquitectura/flujo-datos' },
          ],
        },
        {
          text: 'Módulos',
          items: [
            { text: 'POA', link: '/modulos/poa' },
            { text: 'Estado de Resultados', link: '/modulos/estado-resultados' },
            { text: 'Importaciones', link: '/modulos/importaciones' },
          ],
        },
        {
          text: 'Base de Datos',
          items: [
            { text: 'Esquema', link: '/base-de-datos/esquema' },
            { text: 'Store Mapping', link: '/base-de-datos/store-mapping' },
          ],
        },
      ],
    },

    socialLinks: [],

    footer: {
      message: 'Documentación interna — Equipo de Desarrollo',
    },
  },
})
