<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width,initial-scale=1">

<title>

Cadastro SpinMove

</title>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">
<style>
.plano-card {
    cursor: pointer;
    transition: all .25s ease;
    border: 2px solid transparent;
}

.plano-card:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

.plano-card.selected {
    border: 2px solid #ff7a00;
    box-shadow: 0 0 0 4px rgba(255,122,0,.15);
    transform: scale(1.03);
}
</style>
<style>

body{

background:#f5f6fa;

}

.card{

border:none;

border-radius:20px;

box-shadow:

0 10px 30px rgba(
0,0,0,.08
);

}

.logo{

font-size:28px;

font-weight:700;

color:#ff7a00;

}

.section{

font-size:18px;

font-weight:600;

margin-bottom:20px;

}

</style>

</head>

<body>

<div class="container py-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="text-center mb-4">

<div class="logo">

SPINMOVE

</div>

<p>

Preencha seu cadastro

</p>

</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form method="POST" id="cadastroForm" action="{{ route('cadastro.publico.store') }}">
    @csrf
<input type="hidden" name="fingerprint_id" id="fingerprint_id">
<input type="hidden" name="user_agent" id="user_agent">
<input type="hidden" name="screen_resolution" id="screen_resolution">
<input type="hidden" name="timezone" id="timezone">

<div class="card">

<div class="card-body p-4">

<div class="section">

Dados pessoais

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>

Nome completo

</label>

<input
name="nome"
class="form-control"
value="{{ old('nome') }}"
required>

</div>

<div class="col-md-6 mb-3">

<label>

Telefone

</label>

<input
id="telefone"
name="telefone"
class="form-control"
value="{{ old('telefone') }}"
required>

</div>

<div class="col-md-6 mb-3">

<label>

CPF

</label>

<input
    id="cpf"
    name="cpf"
    class="form-control @error('cpf') is-invalid @enderror"
    value="{{ old('cpf') }}"
    required>

@error('cpf')

<div class="invalid-feedback">

    {{ $message }}

</div>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>

Email

</label>

<input
name="email"
type="email"
class="form-control"
value="{{ old('email') }}"
required>

</div>

<div class="col-md-6 mb-3">

<label>

Nascimento

</label>

<input
type="date"
name="data_nascimento"
class="form-control"
value="{{ old('data_nascimento') }}"
required>

</div>

<div class="col-md-6 mb-3">

<label>

Altura

</label>

<input
name="altura"
class="form-control"
value="{{ old('altura') }}"
required>

</div>

</div>

<hr>

<div class="section">

Endereço

</div>

<div class="row">

    <div class="col-md-3 mb-3">

        <label>CEP</label>

        <input
            id="cep"
            name="cep"
            class="form-control"
            value="{{ old('cep') }}"
            required>

    </div>

    <div class="col-md-6 mb-3">

        <label>Endereço</label>

        <input
            id="endereco"
            name="endereco"
            class="form-control"
            value="{{ old('endereco') }}"
            required>

    </div>

    <div class="col-md-3 mb-3">

        <label>Número</label>

        <input
            name="numero"
            class="form-control"
            value="{{ old('numero') }}"
            required>

    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">

        <label>Bairro</label>

        <input
            id="bairro"
            name="bairro"
            class="form-control"
            value="{{ old('bairro') }}"
            required>

    </div>

    <div class="col-md-4 mb-3">

        <label>Cidade</label>

        <input
            id="cidade"
            name="cidade"
            class="form-control"
            value="{{ old('cidade') }}"
            required>

    </div>

    <div class="col-md-4 mb-3">

        <label>Estado</label>

        <input id="estado" name="estado" class="form-control" value="{{ old('estado') }}" readonly>

    </div>

</div>

<hr>

<div class="section">

Perfil

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>

Profissão

</label>

<input
name="profissao"
class="form-control"
value="{{ old('profissao') }}"
required>

</div>

<div class="col-md-6 mb-3">

<label>

Estado civil

</label>

<select
name="estado_civil"
class="form-control"
required>

<option value="Solteiro(a)"
{{ old('estado_civil')=='Solteiro(a)' ? 'selected':'' }}>
Solteiro(a)
</option>

<option value="Casado(a)"
{{ old('estado_civil')=='Casado(a)' ? 'selected':'' }}>
Casado(a)
</option>

<option value="Divorciado(a)"
{{ old('estado_civil')=='Divorciado(a)' ? 'selected':'' }}>
Divorciado(a)
</option>

<option value="Viúvo(a)"
{{ old('estado_civil')=='Viúvo(a)' ? 'selected':'' }}>
Viúvo
</option>

</select>

</div>

</div>

<hr>

<div class="col-md-12 mb-3">

<label>

Como conheceu a SpinMove?

</label>

<select
name="origem"
class="form-control"
required>

<option value="">
Selecione
</option>

<option value="Instagram"
{{ old('origem')=='Instagram' ? 'selected':'' }}>
Instagram
</option>

<option value="Indicação"
{{ old('origem')=='Indicação' ? 'selected':'' }}>
Indicação
</option>

<option value="Google"
{{ old('origem')=='Google' ? 'selected':'' }}>
Google
</option>

<option value="Facebook"
{{ old('origem')=='Facebook' ? 'selected':'' }}>
Facebook
</option>

<option value="Passando na rua"
{{ old('origem')=='Passando na rua' ? 'selected':'' }}>
Passando na rua
</option>

<option value="Outro"
{{ old('origem')=='Outro' ? 'selected':'' }}>
Outro
</option>

</select>

</div>



<hr>

<div class="alert alert-light border mb-4">

    <strong>Como funciona:</strong><br>

    1. Escolha seu plano<br>
    2. Receba sua bike em casa<br>
    3. Pagamento somente na entrega<br><br>

    <small class="text-muted">
        Sem cobrança antecipada • Cancelamento simples • Entrega agendada
    </small>

</div>
<div class="planos-section">
<div class="row g-3 mb-4">

@foreach($planos as $plano)

@php
    $isRecomendado = $plano->id == $recomendadoId;
    $plano->nome_formatado = match ($plano->duracao_dias) {
    90 => 'Plano 3 meses',
    180 => 'Plano 6 meses',
};
@endphp

<div class="col-md-6">

    <div class="card plano-card h-100"
         onclick="selecionarPlano(this, {{ $plano->id }})"
         style="position:relative; cursor:pointer;">

        @if($isRecomendado)
            <span class="badge"
                  style="position:absolute;top:10px;right:10px;background:#ff7a00;">
                Recomendado para você
            </span>
        @endif

        <div class="card-body p-4">

            <h4 style="font-weight:700;">
                {{ $plano->duracao_dias == 90 ? 'Plano 3 meses' : 'Plano 6 meses' }}
            </h4>

            <p class="text-muted">
                {{ $plano->descricao }}
            </p>

            <h3 style="font-weight:800;">
                R$ {{ number_format($plano->valor_mensal, 2, ',', '.') }}/mês
            </h3>

            <small class="text-muted">
                {{ $plano->nome_formatado }} de acesso
            </small>

        </div>

    </div>

</div>

@endforeach

</div>
</div>
<input
type="hidden"
name="plano_id"
id="plano_id"
value="{{ old('plano_id') }}"
required>

<hr>

<div class="alert alert-light border">

<small>

Ao enviar este cadastro você concorda com os termos da locação.

<a
href="#"
data-bs-toggle="modal"
data-bs-target="#modalTermos"
>

Ler termos completos

</a>

</small>

</div>


<div class="form-check mb-4">

<input

id="aceite"

class="form-check-input"

type="checkbox"

name="aceite"

value="1"

required

>

<label
for="aceite"
class="form-check-label"
>

Li e concordo com os termos da locação SpinMove

</label>

</div>



<button

id="btnEnviar"

disabled

class="btn btn-warning w-100 btn-lg"

>

Aceite os termos para continuar

</button>

</div>

</div>

</form>

</div>

</div>

</div>





<div
class="modal fade"
id="modalTermos"
tabindex="-1"
>

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

Termos da Locação SpinMove

</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal"
></button>

</div>

<div class="modal-body">




<h6>

1. Cadastro e informações

</h6>

<p>

O cliente declara que todas as informações fornecidas neste cadastro são verdadeiras e poderão ser utilizadas pela SpinMove para fins de cadastro, contato, operação da locação e suporte.

</p>


<h6>

2. Propriedade da bike

</h6>

<p>

A bike disponibilizada permanece sendo propriedade da SpinMove durante todo o período da locação, não sendo permitida venda, cessão, empréstimo ou transferência para terceiros sem autorização.

</p>


<h6>

3. Uso e conservação

</h6>

<p>

O cliente se compromete a utilizar o equipamento de forma adequada, mantendo cuidados básicos de conservação e informando qualquer defeito, dano ou problema identificado.

</p>


<h6>

4. Danos, perdas e avarias

</h6>

<p>

Em caso de dano causado por mau uso, perda, extravio, furto ou avarias fora do desgaste natural do equipamento, poderão ser aplicadas cobranças correspondentes aos custos de reparo, manutenção ou reposição.

</p>


<h6>

5. Pagamentos e renovação

</h6>

<p>

A continuidade da locação depende da renovação do plano e da regularidade dos pagamentos conforme condições acordadas entre as partes.

</p>


<h6>

6. Atrasos e inadimplência

</h6>

<p>

Em caso de atraso nos pagamentos, a SpinMove poderá entrar em contato para regularização, suspender renovações, solicitar devolução do equipamento ou aplicar medidas previstas contratualmente.

Persistindo a inadimplência, poderão ser adotadas medidas administrativas e legais para recuperação dos valores e do equipamento.

</p>


<h6>

7. Retirada e devolução

</h6>

<p>

A retirada e devolução do equipamento seguirão os procedimentos operacionais definidos pela SpinMove, mediante alinhamento prévio entre as partes.

</p>


<h6>

8. Endereço de utilização

</h6>

<p>

O cliente declara que o endereço informado será o principal local de utilização do equipamento, salvo comunicação prévia e autorização da SpinMove.

</p>


<h6>

9. Acesso para retirada

</h6>

<p>

Em caso de encerramento da locação ou necessidade operacional, o cliente compromete-se a disponibilizar acesso para retirada do equipamento mediante agendamento.

</p>


<h6>

10. Documentos enviados

</h6>

<p>

Os documentos e informações enviados poderão ser utilizados exclusivamente para validação cadastral, segurança operacional e controle interno da locação.

</p>


<h6>

11. Privacidade e dados

</h6>

<p>

Os dados coletados serão utilizados para operação da locação, contato e suporte, sendo tratados internamente pela SpinMove.

</p>


<h6>

12. Aceite

</h6>

<p>

Ao marcar a opção de aceite e enviar este cadastro, o cliente declara que leu, compreendeu e concorda com os termos apresentados.

</p>

</div>

<div class="modal-footer">

<button
class="btn btn-secondary"
data-bs-dismiss="modal"
>

Fechar

</button>

</div>

</div>

</div>

</div>



<script>
    const cep = document.getElementById('cep');

cep.addEventListener('input', function(e){

    let value = e.target.value.replace(/\D/g,'');

    value = value.replace(
        /^(\d{5})(\d)/,
        '$1-$2'
    );

    e.target.value = value;

});
    </script>
<script>

const aceite =

document.getElementById(
'aceite'
);

const botao =

document.getElementById(
'btnEnviar'
);


aceite.addEventListener(

'change',

function(){

if(
this.checked
){

botao.disabled =
false;

botao.innerHTML =
'Enviar cadastro';

}
else{

botao.disabled =
true;

botao.innerHTML =

'Aceite os termos para continuar';

}

}

);

</script>


<script>

document
.getElementById(
'cpf'
)
.addEventListener(
'input',
function(e){

let value=
e.target.value
.replace(
/\D/g,
''
);

value=
value.replace(
/(\d{3})(\d)/,
'$1.$2'
);

value=
value.replace(
/(\d{3})(\d)/,
'$1.$2'
);

value=
value.replace(
/(\d{3})(\d{1,2})$/,
'$1-$2'
);

e.target.value=
value;

}
);

document
.getElementById(
'telefone'
)
.addEventListener(
'input',
function(e){

let value=
e.target.value
.replace(
/\D/g,
''
);

value=
value.replace(
/^(\d{2})(\d)/,
'($1) $2'
);

value=
value.replace(
/(\d{5})(\d)/,
'$1-$2'
);

e.target.value=
value;

}
);

</script>
<script>

document
.getElementById('cadastroForm')
.addEventListener(
'submit',
function(e){

let plano =
document.getElementById(
'plano_id'
).value;

if(!plano){

e.preventDefault();

alert(
'Selecione um plano antes de continuar'
);

document
.querySelector(
'.planos-section'
)
.scrollIntoView({
behavior:'smooth',
block:'center'
});

return false;

}

}

);

</script>
<script>

document.getElementById('cep')
.addEventListener('input', function(e){

    let value = e.target.value
        .replace(/\D/g,'');

    value = value.replace(
        /^(\d{5})(\d)/,
        '$1-$2'
    );

    e.target.value = value;

});

</script>
<script>

document.getElementById('cep')
.addEventListener('blur', function(){

    let cep = this.value.replace(/\D/g,'');

    if(cep.length !== 8){
        return;
    }

    fetch(
        `https://viacep.com.br/ws/${cep}/json/`
    )
    .then(response => response.json())
    .then(data => {

        if(data.erro){

            alert('CEP não encontrado.');

            return;
        }

        document.getElementById('endereco')
            .value = data.logradouro || '';

        document.getElementById('bairro')
            .value = data.bairro || '';

        document.getElementById('cidade')
            .value = data.localidade || '';

        document.getElementById('estado')
            .value = data.uf || '';

    })
    .catch(() => {

        alert(
            'Erro ao consultar o CEP.'
        );

    });

});

</script>
</body>
<script>

function selecionarPlano(el, planoId) {

    document.querySelectorAll('.plano-card')
        .forEach(card =>
            card.classList.remove('selected')
        );

    el.classList.add('selected');

    document.getElementById(
        'plano_id'
    ).value = planoId;

    const btn =
        document.getElementById(
            'btnEnviar'
        );

    btn.disabled = false;

    btn.innerHTML =
        'Confirmar solicitação';
}

</script>
<script>

window.onload = function(){

let plano =
document.getElementById(
'plano_id'
).value;

if(plano){

let card =
document.querySelector(
`[onclick*="${plano}"]`
);

if(card){

card.classList.add(
'selected'
);

}

}

}

</script>
<script>
document.getElementById('user_agent').value =
    navigator.userAgent;

document.getElementById('screen_resolution').value =
    window.screen.width + 'x' + window.screen.height;

document.getElementById('timezone').value =
    Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
<script src="https://openfpcdn.io/fingerprintjs/v4"></script>

<script>
(async () => {

    const fp = await FingerprintJS.load();

    const result = await fp.get();

    document.getElementById('fingerprint_id').value =
        result.visitorId;

})();
</script>
</html>