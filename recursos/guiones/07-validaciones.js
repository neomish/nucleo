// validador campo solicitado
function validaRequerido( identificador ){
    var campo = new LiveValidation (
        identificador ,
        {
            validMessage: " ",
            wait: 500
        }
    );
    campo.add(
        Validate.Presence ,
        {
            failureMessage: " "
        }
    );
}

// validar nombre de usuario
function validaNombreUsuario( identificador ){
    var campo = new LiveValidation (
        identificador ,
        {
            validMessage: " ",
            wait: 500
        }
    );
    campo.add (
        Validate.Presence,
        {
            failureMessage: " "
        }
    );
    campo.add  (
        Validate.Length,
        {
            minimum: 4 ,
            tooShortMessage : "<4"
        }
    );
}

function validaClave ( identificador ){
    var campo = new LiveValidation (
        identificador ,
        {
            validMessage: " ",
            wait: 500
        }
    );
    campo.add (
        Validate.Presence ,
        {
            failureMessage: " "
        }
    );
    campo.add (
        Validate.Length,    {
            minimum: 4  ,
            tooShortMessage : "<4"
        }
    );
}

/*
function validaClave2( identificador,clave1 ){
    var clave2 = new LiveValidation (
        identificador,
        { validMessage: " Bien" }
    );
     clave2.add (
        Validate.Presence ,
         { failureMessage: " <- Requerido" }
    );
    clave2.add (
    Validate.Confirmation,
    {
        match: clave1 ,
        failureMessage: " <- No coinciden"
    }
    );
}



// validador de numeros de cuatro digitos
function valida4digitos( identificador ){
    var f2 = new LiveValidation (
            identificador ,
            {
                validMessage: " Bien",
                wait: 500
            }
        );
        f2.add (
        Validate.Presence ,
            {
                failureMessage: " <- Requerido"
            }
        );
        f2.add (
            Validate.Numericality , {
                notANumberMessage: " <- Debe ser un n�mero" ,
                minimum: 1000,
                tooLowMessage: " <- n�mero no menor de 4 cifras" ,
                maximum: 9999,
                tooHighMessage: " <- n�mero no mayor de 4 cifras" ,
                onlyInteger: 'true' ,
                notAnIntegerMessage: " <- debe ser entero"
            }
        );
}
*/

// validar numeros positivos
function validaPositivos0( identificador ){
    var campo = new LiveValidation (
            identificador ,
            {
                validMessage: " ",
                wait: 500
            }
        );
        campo.add (
        Validate.Presence ,
            {
                failureMessage: " *"
            }
        );
        campo.add (
            Validate.Numericality , {
                notANumberMessage: " X" ,
                minimum: 0,
                tooLowMessage: "<0"
            }
        );
}

// validar numeros positivos mayores que cero
function validaPositivos1( identificador ){
    var campo = new LiveValidation (
            identificador ,
            {
                validMessage: " ",
                wait: 500
            }
        );
        campo.add (
        Validate.Presence ,
            {
                failureMessage: " *"
            }
        );
        campo.add (
            Validate.Numericality , {
                notANumberMessage: " X" ,
                minimum: 0.00000000001,
                tooLowMessage: " 0"
            }
        );
}

// validar numeros positivos
function validaPorcentaje( identificador ){
    var campo = new LiveValidation (
            identificador ,
            {
                validMessage: " ",
                wait: 500
            }
        );
        campo.add (
        Validate.Presence ,
            {
                failureMessage: " *"
            }
        );
        campo.add (
            Validate.Numericality , {
                notANumberMessage: " X" ,
                minimum: 0,
                tooLowMessage: "<0",
                maximum: 100,
                tooHighMessage: ">100"
            }
        );
}

// validar enteros positivos mayores que cero
function validaEnteros1( identificador ){
    var campo = new LiveValidation (
            identificador ,
            {
                validMessage: " ",
                wait: 500
            }
        );
        campo.add (
        Validate.Presence ,
            {
                failureMessage: " *"
            }
        );
        campo.add (
            Validate.Numericality , {
                notANumberMessage: " X" ,
                minimum: 1,
                tooLowMessage: "<1",
                onlyInteger: 'true' ,
                notAnIntegerMessage: "<."
            }
        );
}

// validar enteros positivos incluyendo el cero
function validaEnteros0( identificador ){
    var campo = new LiveValidation (
            identificador ,
            {
                validMessage: " ",
                wait: 500
            }
        );
        campo.add (
        Validate.Presence ,
            {
                failureMessage: " *"
            }
        );
        campo.add (
            Validate.Numericality , {
                notANumberMessage: " X" ,
                minimum: 0,
                tooLowMessage: "<0",
                onlyInteger: 'true' ,
                notAnIntegerMessage: "<."
            }
        );
}

// validar enteros positivos mayores que con limite
function validaEnterosX( identificador , mayor ){
    var campo = new LiveValidation (
            identificador ,
            {
                validMessage: " ",
                wait: 500
            }
        );
        campo.add (
        Validate.Presence ,
            {
                failureMessage: " *"
            }
        );
        campo.add (
            Validate.Numericality , {
                notANumberMessage: " X" ,
                minimum: 1,
                tooLowMessage: "<1",
                onlyInteger: 'true' ,
                notAnIntegerMessage: "<.",
                maximum: mayor,
                tooHighMessage: ">"+mayor
            }
        );
}

/*
// validar que lo que se ingrese sean solo letras
function validaLetras( identificador ){
    var f2 = new LiveValidation (
     identificador ,    {
     validMessage: " Bien", wait: 500
                        }
                        );
        f2.add (
                Validate.Presence , {
                  failureMessage: " <- Requerido"
                                    }
                );
        f2.add(
                Validate.Exclusion, {
                within: [
                         '/',
                        '&',
                         '=',
                        '?',
                        '�',
                        '�',
                        '!',
                        '*',
                        '+',
                        '-',
                        '@',
                        '#',
                        '[',
                        ']',
                        '{',
                        '}',
                        '(',
                        ')',
                        '>',
                        '<',
                        ',',
                        '.',
                        '0',
                        '1',
                        '2',
                        '3',
                        '4',
                        '5',
                        '6',
                        '7',
                        '8',
                        '9',
                        ],
        partialMatch: true,
            failureMessage: " <- Caracteres no v�lidos"
            }
    );
}

// validar que lo que se ingrese sean solo letras y numeros
function validaLetrasNumerosSimbolos( identificador ){
    var f2 = new LiveValidation (
     identificador ,    {
     validMessage: " Bien", wait: 500
                        }
                        );
        f2.add (
                Validate.Presence , {
                  failureMessage: " <- Requerido"
                                    }
                );
        f2.add(
                Validate.Exclusion, {
                within: [
                        '/',
                        '&',
                        '=',
                        '?',
                        '�',
                        '�',
                        '!',
                        '*',
                        '+',
                        '-',
                        '@',
                        '#',
                        '[',
                        ']',
                        '{',
                        '}',
                        '>',
                        '<',
                        ',',
                        '.',
                        ],
        partialMatch: true,
            failureMessage: " <- Caracteres no v�lidos"
            }
    );
}

// funcion para validar que se ingresen 5 digitos
function valida5digitos( identificador ){
        var f2 = new LiveValidation (
            identificador ,  {
            validMessage: " Bien", wait: 500
                    }
                    );
        f2.add (
            Validate.Presence , {
                failureMessage: " <- Requerido"
                }
            );
        f2.add (
            Validate.Numericality , {
                notANumberMessage: " <- Debe ser un n�mero" ,
                minimum: 10000,
                tooLowMessage: " <- n�mero no menor de 5 cifras",
                maximum: 99999,
                tooHighMessage: " <- n�mero no mayor de 5 cifras" ,
                onlyInteger: 'true' ,
                notAnIntegerMessage: " <- debe ser entero"
                }
            );
}
*/

// validador una seleccion
function validaLista( identificador , opcion ){
    var campo = new LiveValidation (
        identificador ,
        {
            validMessage: " ",
            wait: 500
        }
    );
    campo.add(
        Validate.Exclusion ,
        {
            within: [opcion],
            failureMessage: " *"
        }
    );
}

// Para poder hacer que una area de texto se transforme en editor y sea validada al mismo tiempo
function colocarEditor ( identificador ){
    bkLib.onDomLoaded(
        function() {
            new nicEditor(
            {
                buttonList : ['bold','italic','underline','strikethrough','subscript','superscript']
            }
            ).panelInstance( identificador );
        }
    );
    //fullPanel : true
    validaRequerido( identificador );
}

// Para poder hacer que una area de texto con mas opciones se transforme en editor y sea validada al mismo tiempo
function colocarEditorMedio ( identificador ){
    bkLib.onDomLoaded(
        function() {
            new nicEditor(
            {
                //['bold','italic','underline','left','center','right','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','link','image']
                buttonList : ['bold','italic','underline','strikethrough','subscript','superscript','hr','left','center','right','ol','ul','link','fontSize']
            }
            ).panelInstance( identificador );
        }
    );
    validaRequerido( identificador );
}
