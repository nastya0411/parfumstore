    <div class="receipt">
        <div class="header">
            <div class="company-name">"Mon-Parfum"</div>
            <div>ИНН 123456789012</div>
            <div>Кассовый аппарат №123456789012</div>
        </div>
        
        <div class="receipt-title">КАССОВЫЙ ЧЕК</div>
        
        <div class="receipt-info">
            <div>Чек: №<?= rand(1500, 4000) ?></div>
            <div>Дата: <?= date("d.m.Y H:i:s") ?></div>
            <div>Кассир: Иванова А.П.</div>
        </div>
        
        <table class="items-table">
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Кол-во</th>
                    <th class="align-right">Цена</th>
                    <th class="align-right">Сумма</th>
                </tr>
            </thead>
            <tbody>
                <?php $sum = 0; ?>                
                <?php foreach ($items as $key => $item): ?>
                    <?php $sum += $item->cost ?>
                    <tr>
                        <td><?= $item->product->title ?></td>
                        <td><?= $item->amount ?></td>
                        <td class="align-right"><?= Yii::$app->formatter->asDecimal($item->product->price, 2) ?></td>
                        <td class="align-right"><?= Yii::$app->formatter->asDecimal($item->cost, 2) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
        <div class="divider"></div>
        
        <div class="total">
            ИТОГ: <?= Yii::$app->formatter->asDecimal($sum, 2) ?> ₽
        </div>
        
        <div class="receipt-info">
            <div>ФН: 1234567890123456</div>
            <div>ФД: 1234</div>
            <div>ФП: 1234567890</div>
        </div>
        
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://ofd.ru/check/1234567890123456/1234/1234567890" alt="QR-код чека">
        </div>
        
      
        
        <div class="footer">
            <div>СПАСИБО ЗА ПОКУПКУ!</div>
            <div>Проверить чек можно на сайте</div>
            <div><a href="https://ofd.ru" class="ofd-link">ofd.ru</a> или в приложении ФНС</div>
            <div>Телефон для вопросов: 8-800-123-45-67</div>
        </div>
    </div>

<?php
$this->registerCss(
    <<<CSS
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

CSS
);