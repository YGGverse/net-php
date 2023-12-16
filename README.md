# net-php

Network Library for PHP with native Yggdrasil support

## Install

`composer require yggverse/net`

## Usage

### Socket

#### Check socket is open

```
var_dump(
    \Yggverse\Net\Socket::isOpen('yo.index', 80)
);
```

#### Check host valid

```
var_dump(
    \Yggverse\Net\Socket::isHost('yo.index')
);
```

#### Check port valid

```
var_dump(
    \Yggverse\Net\Socket::isPort(80)
);
```

### Dig

#### Resolve records

```
var_dump(
    \Yggverse\Net\Dig::records('yo.index', ['A', 'AAAA'])
);
```

#### Check hostname valid

```
var_dump(
    \Yggverse\Net\Dig::isHostName('yo.index')
);
```

#### Check record valid

```
var_dump(
    \Yggverse\Net\Dig::isRecord('A')
);
```

#### Check record value valid

```
var_dump(
    \Yggverse\Net\Dig::isRecordValue('A', '127.0.0.1')
);
```