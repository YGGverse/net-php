# dns-php

DNS Library for PHP with native Yggdrasil support

## Install

`composer require yggverse/dns`

## Usage

### Resolve records

```
var_dump(
    \Yggverse\Dns\Dig::records('yo.index', ['A', 'AAAA'])
);
```

### Check hostname valid

```
var_dump(
    \Yggverse\Dns\Dig::isHostName('yo.index')
);
```

### Check record valid

```
var_dump(
    \Yggverse\Dns\Dig::isRecord('A')
);
```

### Check record value valid

```
var_dump(
    \Yggverse\Dns\Dig::isRecordValue('A', '127.0.0.1')
);
```