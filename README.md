# WooCommerce Krayin CRM - Pagopar Addon

Este es un plugin "hijo" o addon para la integración principal de **WooCommerce Krayin CRM**.

## 🎯 Propósito

El plugin de pasarela de pagos **Pagopar** para WooCommerce no guarda el método de pago específico (ej: Tarjeta de Crédito, Billetera, QR) en un campo de metadatos estructurado. En su lugar, envía esta información en una **Nota del Pedido** (Order Note) cuando se confirma el pago.

Este addon tiene una única función:
1.  Escuchar cuando se añade una nota al pedido (`woocommerce_order_note_added`).
2.  Detectar si la nota proviene de Pagopar y contiene la "Forma de Pago".
3.  Guardar ese dato en un metadato limpio y utilizable: `_pagopar_payment_method`.

## ⚙️ Integración con Krayin Lead Sync

El plugin principal (**WooCommerce Krayin CRM Integration**) utiliza este metadato `_pagopar_payment_method` para aplicar **Reglas de Comisión Avanzadas**.

Por ejemplo, puedes configurar en el plugin principal que:
- "Tarjeta de Crédito" tenga una comisión del 6.5%.
- "QR" tenga una comisión del 1.0%.

Sin este addon activado, el plugin principal no podrá distinguir entre los tipos de pago de Pagopar y usará la comisión general configurada para la pasarela.

## 📋 Requisitos

- WooCommerce
- WooCommerce Pagopar Plugin (Oficial)
- WooCommerce Krayin CRM Integration (Plugin Padre)

## 🚀 Instalación

1.  Sube la carpeta `woocommerce-krayin-pagopar-addon` al directorio `/wp-content/plugins/` de tu sitio WordPress.
2.  Activa el plugin desde el menú **Plugins** en WordPress.
3.  ¡Listo! No requiere configuración adicional. Funcionará silenciosamente en segundo plano.
