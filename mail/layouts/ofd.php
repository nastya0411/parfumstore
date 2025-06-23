<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чек ОФД</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 400px;
            margin: 0 auto;
            padding: 15px;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .receipt {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ccc;
        }
        
        .company-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .receipt-title {
            font-size: 16px;
            margin: 10px 0;
            text-align: center;
            font-weight: bold;
        }
        
        .receipt-info {
            font-size: 12px;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }
        
        .items-table .align-right {
            text-align: right;
        }
        
        .total {
            font-weight: bold;
            text-align: right;
            margin: 15px 0;
            font-size: 16px;
        }
        
        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            line-height: 1.4;
        }
        
        .qr-code {
            text-align: center;
            margin: 15px 0;
        }
        
        .qr-code img {
            width: 120px;
            height: 120px;
        }
        
        .ofd-link {
            color: #0066cc;
            text-decoration: none;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
        }
        
        .divider {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
        <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>