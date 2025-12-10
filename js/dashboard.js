document.addEventListener("DOMContentLoaded", function () {
    const url = "index.php?r=produccion/dashboard-produccion";

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if(data.status === "success") {
                // === Producción por Día ===
                const ctxDia = document.getElementById('chartPorDia').getContext('2d');
                new Chart(ctxDia, {
                    type: 'bar',
                    data: {
                        labels: data.produccion_dia.map(d => d.fecha_extraido),
                        datasets: [{
                            label: 'Litros',
                            data: data.produccion_dia.map(d => d.total_litros),
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } }
                    }
                });

                // === Producción por Animal ===
                const ctxAnimal = document.getElementById('chartPorAnimal').getContext('2d');
                new Chart(ctxAnimal, {
                    type: 'bar',
                    data: {
                        labels: data.produccion_animal.map(d => d.animal),
                        datasets: [{
                            label: 'Litros',
                            data: data.produccion_animal.map(d => d.total_litros),
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        }]
                    },
                    options: { responsive: true }
                });

                // === Producción por Tipo de Leche ===
                const ctxTipo = document.getElementById('chartPorTipoLeche').getContext('2d');
                new Chart(ctxTipo, {
                    type: 'pie',
                    data: {
                        labels: data.produccion_tipo.map(d => d.tipo_leche),
                        datasets: [{
                            data: data.produccion_tipo.map(d => d.total_litros),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)'
                            ]
                        }]
                    },
                    options: { responsive: true }
                });
            }
        })
        .catch(err => console.error("Error al cargar el dashboard:", err));
});





