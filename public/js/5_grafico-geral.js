
            $(document).ready(function () {
                var ctx = document.getElementById("grafico_participacoes_geral").getContext("2d");
                var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28',],
                    labely:["481"],
                    datasets: [
                    {
                        label: "Participações",
                        data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,4,0,],
                        backgroundColor: "#22a32f",
                    },
                    {
                        label: "Ausências", 
                        data: [481,481,481,481,481,481,481,481,481,481,481,481,481,481,481,481,481,481,481,481,480,481,481,481,481,481,477,481,],
                        backgroundColor: "#dbd96b",
                    },
            
                    ],
                },
                });
            });
        