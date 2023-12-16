# net-php

Network Library for PHP with native Yggdrasil support

## Install

`composer require yggverse/net`

## Usage

### Resolve records

```
var_dump(
    \Yggverse\Net\Dig::records('yo.index', ['A', 'AAAA'])
);
```

### Check hostname valid

```
var_dump(
    \Yggverse\Net\Dig::isHostName('yo.index')
);
```

### Check record valid

```
var_dump(
    \Yggverse\Net\Dig::isRecord('A')
);
```

### Check record value valid

```
var_dump(
    \Yggverse\Net\Dig::isRecordValue('A', '127.0.0.1')
);
```