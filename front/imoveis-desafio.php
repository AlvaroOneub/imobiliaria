<title> Imoveis desafio </title>
<?php require_once("header.php"); ?>

<div class="container">
  <div class="row justify-content-md-center">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">codigo</th>
          <th scope="col">Endereço</th>
          <th scope="col">Proprietario</th>
          <th scope="col">Agenciador</th>
          <th scope="col">UF Proprietario</th>
        </tr>
      </thead>
      <tbody id="casasTbody">
       
      </tbody>
    </table>
  </div>
</div>

<script>
(function() {
      listarImoveis(0, 10)
  })();

  function listarImoveis(offset, limit){
     fetch(`http://localhost/imobiliaria/backend/imovel/desafio`, {
            method: 'GET',
            //body: JSON.stringify(myJson),
            mode: 'no-cors',
            headers: {
                'content-type': 'application/json'
            }
        })
        .then(function (data) { 
            console.log(data);
            return data.json().then(function(casas) {
              console.log('here3')
            let tabelaCasas = document.querySelector("#casasTbody")
            tabelaCasas.innerHTML = ""
            casas.dados.forEach(function(casa){
              let trElement = document.createElement("tr")
              let tdId = document.createElement("td")
              let tdEndereco = document.createElement("td")
              let tdProprietario = document.createElement("td")
              let tdAgenciador = document.createElement("td")
              let tdUfProprietario = document.createElement("td")
              trElement.id = "casa_" + casa.id
              trElement.dataset.id =  casa.id
              trElement.dataset.endereco =  casa.endereco
              trElement.dataset.proprietario =  casa.proprietario
              trElement.dataset.agenciador =  casa.agenciador
              trElement.dataset.ufProprietario =  casa.uf_proprietario
              tdId.innerHTML = casa.id
              tdEndereco.innerHTML= casa.endereco
              tdProprietario.innerHTML = casa.proprietario
              tdAgenciador.innerHTML = casa.agenciador
              tdUfProprietario.innerHTML = casa.uf_proprietario
              trElement.appendChild(tdId)
              trElement.appendChild(tdEndereco)
              trElement.appendChild(tdProprietario)
              trElement.appendChild(tdAgenciador)
              trElement.appendChild(tdUfProprietario)
              tabelaCasas.appendChild(trElement)
            })
            console.log(casas)
         });
        })
        
   }



</script>
<?php require_once("footer.php"); ?>