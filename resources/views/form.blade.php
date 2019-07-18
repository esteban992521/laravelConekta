<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-4 mx-auto">
                <form action="{{ route('conekta.doPayment') }}" method="POST" id="card-form">
                    <span class="card-errors"></span>
                    <div class="form-group">
                        <label>
                            <span>Nombre del tarjetahabiente</span>
                        </label>
                        <input class="form-control" type="text" size="20" data-conekta="card[name]">
                    </div>
                    <div class="class="form-group"">
                        <label>
                            <span>Número de tarjeta de crédito</span>
                        </label>
                        <input class="form-control" type="text" size="20" data-conekta="card[number]">
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label>
                                <span>CVC</span>
                            </label>
                            <input class="form-control" type="text" size="4" data-conekta="card[cvc]">
                        </div>
                        <div class="col-8 text-center">
                            <label class="d-inline-block">
                                <span>Fecha de expiración (MM/AAAA)</span>
                            </label>
                            <input class="form-control w-25 d-inline-block" type="text" size="2" data-conekta="card[exp_month]">
                            <span class="d-inline-block">/</span>
                            <input class="form-control w-25 d-inline-block" type="text" size="4" data-conekta="card[exp_year]">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">Crear token</button>    
                        @csrf
                    </div>
                    
                    
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

    <script>
        Conekta.setPublicKey('{{ config('conekta.public_key') }}');
        var conektaSuccessResponseHandler = function(token) {
            var $form = $("#card-form");
            //Inserta el token_id en la forma para que se envíe al servidor
            $form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));
            $form.get(0).submit(); //Hace submit
        };
        
        var conektaErrorResponseHandler = function(response) {
            var $form = $("#card-form");
            $form.find(".card-errors").text(response.message_to_purchaser);
            $form.find("button").prop("disabled", false);
        };

        //jQuery para que genere el token después de dar click en submit
        $(function () {
            $("#card-form").submit(function(event) {
                var $form = $(this);
                // Previene hacer submit más de una vez
                $form.find("button").prop("disabled", true);
                Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
                return false;
            });
        });
    </script>
</body>
</html>