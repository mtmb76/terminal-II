
            $(document).ready(function () {
                var ctx = document.getElementById("grafico_participacoes_geral").getContext("2d");
                var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28',],
                    labely:["487"],
                    datasets: [
                    {
                        label: "Participações",
                        data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,5,3,0,0,0,],
                        backgroundColor: "#22a32f",
                    },
                    {
                        label: "Ausências", 
                        data: [487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,487,482,484,487,487,487,],
                        backgroundColor: "#dbd96b",
                    },
            
                    ],
                },
                });
            });
        