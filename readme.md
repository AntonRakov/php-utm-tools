# PHP Tools for utm-labels

**Usage example:**

`<?php`

`use AntonRakov/Utm;`

`$utmClient = new Utm;`

`// Set utm-labels in cookie from GET-parameters`  
`$utmClient = (new Utm)->set($_GET);`

`// Get utm-labels from cookie`  
`$utmClient->get();`

`// Get utm-label value form cookie by code`  
`$utmClient->getUtmValueByCode('utm_source');`

**Пример использования:**

`<?php`

`use AntonRakov/Utm;`

`$utmClient = new Utm;`

`// Запись utm-меток в cookie из GET-параметров`  
`$utmClient = (new Utm)->set($_GET);`

`// Получение utm-меток из cookie`  
`$utmClient->get();`

`// Получение utm-меток из cookie по названию метки`  
`$utmClient->getUtmValueByCode('utm_source');`
