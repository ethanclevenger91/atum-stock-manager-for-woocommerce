<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb5eb915d7249c0bad4569c36eaa9393c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Atum\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Atum\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Atum\\Addons\\Addons' => __DIR__ . '/../..' . '/classes/Addons/Addons.php',
        'Atum\\Addons\\Updater' => __DIR__ . '/../..' . '/classes/Addons/Updater.php',
        'Atum\\Bootstrap' => __DIR__ . '/../..' . '/classes/Bootstrap.php',
        'Atum\\Components\\AtumCapabilities' => __DIR__ . '/../..' . '/classes/Components/AtumCapabilities.php',
        'Atum\\Components\\AtumException' => __DIR__ . '/../..' . '/classes/Components/AtumException.php',
        'Atum\\Components\\AtumListTables\\AtumListPage' => __DIR__ . '/../..' . '/classes/Components/AtumListTables/AtumListPage.php',
        'Atum\\Components\\AtumListTables\\AtumListTable' => __DIR__ . '/../..' . '/classes/Components/AtumListTables/AtumListTable.php',
        'Atum\\Components\\AtumOrders\\AtumComments' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/AtumComments.php',
        'Atum\\Components\\AtumOrders\\AtumOrderPostType' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/AtumOrderPostType.php',
        'Atum\\Components\\AtumOrders\\Items\\AtumOrderItemFee' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Items/AtumOrderItemFee.php',
        'Atum\\Components\\AtumOrders\\Items\\AtumOrderItemProduct' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Items/AtumOrderItemProduct.php',
        'Atum\\Components\\AtumOrders\\Items\\AtumOrderItemShipping' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Items/AtumOrderItemShipping.php',
        'Atum\\Components\\AtumOrders\\Items\\AtumOrderItemTax' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Items/AtumOrderItemTax.php',
        'Atum\\Components\\AtumOrders\\Items\\AtumOrderItemTrait' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Items/AtumOrderItemTrait.php',
        'Atum\\Components\\AtumOrders\\Models\\AtumOrderItemModel' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Models/AtumOrderItemModel.php',
        'Atum\\Components\\AtumOrders\\Models\\AtumOrderModel' => __DIR__ . '/../..' . '/classes/Components/AtumOrders/Models/AtumOrderModel.php',
        'Atum\\Components\\DashboardWidget' => __DIR__ . '/../..' . '/classes/Components/DashboardWidget.php',
        'Atum\\Components\\HelpPointers' => __DIR__ . '/../..' . '/classes/Components/HelpPointers.php',
        'Atum\\Dashboard\\Statistics' => __DIR__ . '/../..' . '/classes/Dashboard/Statistics.php',
        'Atum\\DataExport\\DataExport' => __DIR__ . '/../..' . '/classes/DataExport/DataExport.php',
        'Atum\\DataExport\\Models\\ModelInterface' => __DIR__ . '/../..' . '/classes/DataExport/Models/ModelInterface.php',
        'Atum\\DataExport\\Models\\POModel' => __DIR__ . '/../..' . '/classes/DataExport/Models/POModel.php',
        'Atum\\DataExport\\Reports\\HtmlReport' => __DIR__ . '/../..' . '/classes/DataExport/Reports/HtmlReport.php',
        'Atum\\InboundStock\\InboundStock' => __DIR__ . '/../..' . '/classes/InboundStock/InboundStock.php',
        'Atum\\InboundStock\\Inc\\ListTable' => __DIR__ . '/../..' . '/classes/InboundStock/Inc/ListTable.php',
        'Atum\\Inc\\Ajax' => __DIR__ . '/../..' . '/classes/Inc/Ajax.php',
        'Atum\\Inc\\Globals' => __DIR__ . '/../..' . '/classes/Inc/Globals.php',
        'Atum\\Inc\\Helpers' => __DIR__ . '/../..' . '/classes/Inc/Helpers.php',
        'Atum\\Inc\\Hooks' => __DIR__ . '/../..' . '/classes/Inc/Hooks.php',
        'Atum\\Inc\\Main' => __DIR__ . '/../..' . '/classes/Inc/Main.php',
        'Atum\\Inc\\Upgrade' => __DIR__ . '/../..' . '/classes/Inc/Upgrade.php',
        'Atum\\InventoryLogs\\InventoryLogs' => __DIR__ . '/../..' . '/classes/InventoryLogs/InventoryLogs.php',
        'Atum\\InventoryLogs\\Items\\LogItemFee' => __DIR__ . '/../..' . '/classes/InventoryLogs/Items/LogItemFee.php',
        'Atum\\InventoryLogs\\Items\\LogItemProduct' => __DIR__ . '/../..' . '/classes/InventoryLogs/Items/LogItemProduct.php',
        'Atum\\InventoryLogs\\Items\\LogItemShipping' => __DIR__ . '/../..' . '/classes/InventoryLogs/Items/LogItemShipping.php',
        'Atum\\InventoryLogs\\Items\\LogItemTax' => __DIR__ . '/../..' . '/classes/InventoryLogs/Items/LogItemTax.php',
        'Atum\\InventoryLogs\\Items\\LogItemTrait' => __DIR__ . '/../..' . '/classes/InventoryLogs/Items/LogItemTrait.php',
        'Atum\\InventoryLogs\\Models\\Log' => __DIR__ . '/../..' . '/classes/InventoryLogs/Models/Log.php',
        'Atum\\InventoryLogs\\Models\\LogItem' => __DIR__ . '/../..' . '/classes/InventoryLogs/Models/LogItem.php',
        'Atum\\Modules\\ModuleManager' => __DIR__ . '/../..' . '/classes/Modules/ModuleManager.php',
        'Atum\\PurchaseOrders\\Items\\POItemFee' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Items/POItemFee.php',
        'Atum\\PurchaseOrders\\Items\\POItemProduct' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Items/POItemProduct.php',
        'Atum\\PurchaseOrders\\Items\\POItemShipping' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Items/POItemShipping.php',
        'Atum\\PurchaseOrders\\Items\\POItemTax' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Items/POItemTax.php',
        'Atum\\PurchaseOrders\\Items\\POItemTrait' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Items/POItemTrait.php',
        'Atum\\PurchaseOrders\\Models\\POItem' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Models/POItem.php',
        'Atum\\PurchaseOrders\\Models\\PurchaseOrder' => __DIR__ . '/../..' . '/classes/PurchaseOrders/Models/PurchaseOrder.php',
        'Atum\\PurchaseOrders\\PurchaseOrders' => __DIR__ . '/../..' . '/classes/PurchaseOrders/PurchaseOrders.php',
        'Atum\\Settings\\Settings' => __DIR__ . '/../..' . '/classes/Settings/Settings.php',
        'Atum\\StockCentral\\Inc\\ListTable' => __DIR__ . '/../..' . '/classes/StockCentral/Inc/ListTable.php',
        'Atum\\StockCentral\\StockCentral' => __DIR__ . '/../..' . '/classes/StockCentral/StockCentral.php',
        'Atum\\Suppliers\\Suppliers' => __DIR__ . '/../..' . '/classes/Suppliers/Suppliers.php',
        'CGIF' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFCOLORTABLE' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFFILEHEADER' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFIMAGE' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFIMAGEHEADER' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFLZW' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'FPDF_TPL' => __DIR__ . '/..' . '/setasign/fpdi/fpdf_tpl.php',
        'FPDI' => __DIR__ . '/..' . '/setasign/fpdi/fpdi.php',
        'FilterASCII85' => __DIR__ . '/..' . '/setasign/fpdi/filters/FilterASCII85.php',
        'FilterASCIIHexDecode' => __DIR__ . '/..' . '/setasign/fpdi/filters/FilterASCIIHexDecode.php',
        'FilterLZW' => __DIR__ . '/..' . '/setasign/fpdi/filters/FilterLZW.php',
        'INDIC' => __DIR__ . '/..' . '/mpdf/mpdf/classes/indic.php',
        'MYANMAR' => __DIR__ . '/..' . '/mpdf/mpdf/classes/myanmar.php',
        'OTLdump' => __DIR__ . '/..' . '/mpdf/mpdf/classes/otl_dump.php',
        'PDFBarcode' => __DIR__ . '/..' . '/mpdf/mpdf/classes/barcode.php',
        'SEA' => __DIR__ . '/..' . '/mpdf/mpdf/classes/sea.php',
        'SVG' => __DIR__ . '/..' . '/mpdf/mpdf/classes/svg.php',
        'TTFontFile' => __DIR__ . '/..' . '/mpdf/mpdf/classes/ttfontsuni.php',
        'TTFontFile_Analysis' => __DIR__ . '/..' . '/mpdf/mpdf/classes/ttfontsuni_analysis.php',
        'UCDN' => __DIR__ . '/..' . '/mpdf/mpdf/classes/ucdn.php',
        'bmp' => __DIR__ . '/..' . '/mpdf/mpdf/classes/bmp.php',
        'cssmgr' => __DIR__ . '/..' . '/mpdf/mpdf/classes/cssmgr.php',
        'directw' => __DIR__ . '/..' . '/mpdf/mpdf/classes/directw.php',
        'fpdi_pdf_parser' => __DIR__ . '/..' . '/setasign/fpdi/fpdi_pdf_parser.php',
        'grad' => __DIR__ . '/..' . '/mpdf/mpdf/classes/grad.php',
        'mPDF' => __DIR__ . '/..' . '/mpdf/mpdf/mpdf.php',
        'meter' => __DIR__ . '/..' . '/mpdf/mpdf/classes/meter.php',
        'mpdfform' => __DIR__ . '/..' . '/mpdf/mpdf/classes/mpdfform.php',
        'otl' => __DIR__ . '/..' . '/mpdf/mpdf/classes/otl.php',
        'pdf_context' => __DIR__ . '/..' . '/setasign/fpdi/pdf_context.php',
        'tocontents' => __DIR__ . '/..' . '/mpdf/mpdf/classes/tocontents.php',
        'wmf' => __DIR__ . '/..' . '/mpdf/mpdf/classes/wmf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb5eb915d7249c0bad4569c36eaa9393c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb5eb915d7249c0bad4569c36eaa9393c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb5eb915d7249c0bad4569c36eaa9393c::$classMap;

        }, null, ClassLoader::class);
    }
}
