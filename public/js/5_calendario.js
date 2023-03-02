
            $(document).ready(function () {
                $('#container').simpleCalendar({
                    fixedStartDay: true,
                    displayYear: true,
                    disableEventDetails: false,
                    disableEmptyDetails: true,
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    events: [
                    {startDate: "2023-02-22",  endDate: "2023-02-22",  summary:"<a style='font-size:14px; color:#eee089;' href='http://localhost:8000/evento/view/6'>Evento #6</a><br>Turno: 3º<br>Setor: Administrativo<br>Tema: Teste"},{startDate: "2023-02-28",  endDate: "2023-02-28",  summary:"<a style='font-size:14px; color:#eee089;' href='http://localhost:8000/evento/view/4'>Evento #4</a><br>Turno: 2º<br>Setor: Operacional<br>Tema: Teste"},{startDate: "2023-03-11",  endDate: "2023-03-11",  summary:"<a style='font-size:14px; color:#eee089;' href='http://localhost:8000/evento/view/5'>Evento #5</a><br>Turno: 2º<br>Setor: Operacional<br>Tema: Teste"},
                    ],
                });
            });
        