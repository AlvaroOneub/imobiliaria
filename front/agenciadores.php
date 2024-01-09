<title> Inicio </title>
<?php require_once("header.php"); ?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-8">
    <h1>Lista de agenciadores</h1>
    <form id="cadastrarAgenciador">
      <div class="form-group">
        <label for="">Nome</label>
        <input type="text" name="nome" class="form-control" id="nome" required>
      </div>
      <div class="form-group">
        <label for="">email</label>
        <input type="email" name="email" class="form-control" id="email" required>
      </div>
      <div class="form-group">
        <label for="cliente">telefone</label>
        <input type="text" name="telefone" class="form-control" id="telefone" required>
      </div>
      <div class="form-group">
        <label for="creci">creci</label>
        <input type="text" name="creci" class="form-control" id="creci" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <button class="btn" id="pagina_anterior">Anterior</button>
    <button class="btn" id="proxima_pagina">Próxima</button>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">codigo</th>
          <th scope="col">nome</th>
          <th scope="col">email</th>
          <th scope="col">telefone</th>
          <th scope="col">creci</th>
          <th scope="col">Apagar</th>
        </tr>
      </thead>
      <tbody id="agenciadoresTbody">
       
      </tbody>
    </table>
  </div>
</div>
</div>

<script>
	(function() {
   		listarAgenciadores(0, 10)
	})();

	function listarAgenciadores(offset, limit){
		 fetch(`http://localhost/imobiliaria/backend/agenciador/offset=${offset}&limit=${limit}`, {
            method: 'GET',
            //body: JSON.stringify(myJson),
            mode: 'no-cors',
            headers: {
                'content-type': 'application/json'
            }
        })
        .then(function (data) { 
            return data.json().then(function(agenciadores) {
            let tabelaAgenciadores = document.querySelector("#agenciadoresTbody")
            tabelaAgenciadores.innerHTML = ""
      		  agenciadores.dados.forEach(function(agenciador){
              let trElement = document.createElement("tr")
              let tdId = document.createElement("td")
              let tdNome = document.createElement("td")
              let tdEmail = document.createElement("td")
              let tdTelefone = document.createElement("td")
              let tdCreci = document.createElement("td")
              let tdApagar = document.createElement("td")
              let btnApagar = document.createElement('button')
              trElement.id = "agenciador_" + agenciador.id
              trElement.dataset.id =  agenciador.id
              trElement.dataset.email =  agenciador.email
              trElement.dataset.telefone =  agenciador.telefone
              tdId.innerHTML = agenciador.id
              tdNome.innerHTML= agenciador.nome
              tdEmail.innerHTML= agenciador.email
              tdCreci.innerHTML = agenciador.creci
              tdTelefone.innerHTML = agenciador.telefone
              tdApagar.appendChild(btnApagar)
              btnApagar.innerHTML = "APAGAR"
              btnApagar.dataset.agenciador_id = agenciador.id
              btnApagar.classList.add("btn")
              btnApagar.classList.add("btn-primary")
              btnApagar.addEventListener("click", deletarAgenciador)
              trElement.appendChild(tdId)
              trElement.appendChild(tdNome)
              trElement.appendChild(tdEmail)
              trElement.appendChild(tdTelefone)
              trElement.appendChild(tdCreci)
              trElement.appendChild(tdApagar)
              tabelaAgenciadores.appendChild(trElement) 
            })
            document.querySelector("#pagina_anterior").dataset.url = agenciadores.anterior
            document.querySelector("#proxima_pagina").dataset.url=agenciadores.proxima
   			 });
        })
        
	 }
 

  /*Cadastro de agenciador */
  function cadastrarAgenciador(agenciador){
       fetch(`http://localhost/imobiliaria/backend/agenciador`, {
            method: 'POST',
            body: JSON.stringify(agenciador),
            mode: 'no-cors',
            headers: {
                'content-type': 'application/json'
            }
        })
        .then(function (data) { 
            return data.json().then(function(agenciadores) {
            if(data.status == 201){
              listarAgenciadores(0, 10)
              alert('agenciador cadastrado com sucesso')
            }
             else
              alert('agenciador já cadastrado')
         });
        })
        
  }
  btnCadastrarAgenciador = document.querySelector("#cadastrarAgenciador")
  btnCadastrarAgenciador.addEventListener("submit", (e)=>{
     e.preventDefault()
      let myJson = {
              "nome" : "",
              "email": "",
              "telefone" : "",
              "creci": ""
      }
      myJson.nome = this.nome.value
      myJson.email = this.email.value
      myJson.telefone = this.telefone.value
      myJson.creci = this.creci.value
        
      //console.log(myJson)
      cadastrarAgenciador(myJson)
  })

  function deletarAgenciador(){
       codigo = this.dataset.agenciador_id
      fetch(`http://localhost/imobiliaria/backend/agenciador/${codigo}`, {
            method: 'DELETE',
            headers: {
                'content-type': 'application/json'
            }
        })
        .then(function (data) { 
            return data.json().then(function(agenciador) {
            if(data.status == 200){
              listarAgenciadores(0, 10)
              alert('agenciador apagado com sucesso')
            }
             else
              alert('agenciador não cadastrado')
         });
        })
  }

  /*configura paginacao*/
  document.querySelector("#proxima_pagina").addEventListener("click", function(){
    data = this.dataset.url.split("&")
    offset = data[0].split("=")[1]
    limit = data[1].split("=")[1]
    listaragenciadores(offset, limit)
  })

  document.querySelector("#pagina_anterior").addEventListener("click", function(){
    data = this.dataset.url.split("&")
    offset = data[0].split("=")[1]
    limit = data[1].split("=")[1]
    listaragenciadores(offset, limit)
  })



</script>
<?php require_once("footer.php"); ?>