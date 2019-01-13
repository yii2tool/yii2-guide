Установка
===

Устанавливаем зависимость:

```
composer require yii2module/yii2-guide
```

Создаем полномочие:

```
oGuideModify
```

Объявляем модуль:

```php
return [
	'modules' => [
		// ...
		'guide' => 'class' => 'yii2module\guide\module\Module',
		// ...
	],
];
```

Объявляем домен:

```php
return [
	'components' => [
		// ...
		'guide' => [
			'class' => 'yii2lab\domain\Domain',
			'path' => 'yii2module\guide\domain',
			'repositories' => [
				'project' => [
					'class' => ActiveDiscRepository::class,
					'table' => 'project',
					'path' => '@yii2module/guide/data',
				],
				'article' => Driver::FILE,
				'chapter' => Driver::FILE,
			],
			'services' => [
				'project' => ActiveBaseService::class,
				'article',
				'chapter',
			],
		],
		// ...
	],
];
```
