# JSON-TO-XLSX
Convert one Json on javascript to *.xlsx

## clon

```Bash
$ git clone https://github.com/erickMalagon/JSON-TO-XLSX.git
```

## Uso

Simple : )

```JavaScript
var xlsx2json = require('JSON-TO-XLSX/xlsx2json');
xlsx2json('path_to_xlsx_file').then(jsonArray => {
    ...
});
```

### xlsx2json(pathToXlsx, [options], [callback])

#### Donde ..

* __pathToXlsx__ String  

* __options__ Object _(optional)_
  * ```sheet```
    * {Number} (*zero-based sheet index)
    * {String}
    * {Array}
    
    Si options.sheet no se es seteada, todo el array pasara a la misma hoja.

* __callback__ Function _(optional)_  
  * function(error, jsonArray) {}

