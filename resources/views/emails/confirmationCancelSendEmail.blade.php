<x-mail::message>
## <center>Cancelamento de Inscrição</center>

<p style="text-align:center;">
    <img src="https://img.icons8.com/color/96/000000/cancel.png" style="width:100px;height:100px">
</p>

### <center>Sua inscrição foi cancelada com sucesso</center>  

---

### <span style="color:grey">Dados do Evento:</span>

- **Nome:** <span style="color:grey">{{ $dataEmail['name'] ?? '' }}</span>
- **Localização:** <span style="color:grey">{{ $dataEmail['location'] ?? '' }}</span>
- **Data e Hora de Início:** <span style="color:grey">{{ $dataEmail['start_date'] ?? '' }}</span>
- **Data e Hora de Término:** <span style="color:grey">{{ $dataEmail['end_date'] ?? '' }}</span>
- **Capacidade:** <span style="color:grey">{{ $dataEmail['capacity'] ?? '' }}</span>
- **Categoria:** <span style="color:grey">{{ $dataEmail['categoria'] ?? '' }}</span>

---

### <span style="color:grey">Dados do Participante:</span>

- **Nome:** <span style="color:grey">{{ $dataEmail['participant_name'] ?? '' }}</span>
- **Email:** <span style="color:grey">{{ $dataEmail['email'] ?? '' }}</span>
- **CPF:** <span style="color:grey">{{ $dataEmail['cpf'] ?? '' }}</span>
- **Data de Nascimento:** <span style="color:grey">{{ $dataEmail['data_birth'] ?? '' }}</span>
- **Endereço:** <span style="color:grey">{{ $dataEmail['address'] ?? '' }}</span>

</x-mail::message>