// Pasa los datos de PHP a JS de forma segura
       
        // --- Gráfico de Barras: Préstamos por Mes ---
        const prestamosMesContainer = document.querySelector("#prestamosPorMesChart");
        // Verificamos que el contenedor exista Y que haya al menos un valor mayor a 0
        if (prestamosMesContainer && prestamosMesData.valores && prestamosMesData.valores.some(v => v > 0)) {
            var prestamosMesOptions = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Préstamos',
                    data: prestamosMesData.valores
                }],
                xaxis: {
                    categories: prestamosMesData.labels
                },
                yaxis: {
                    title: {
                        text: 'Cantidad de Préstamos'
                    }
                },
                colors: ['#0d6efd'], // Color primario de Bootstrap
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 5
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // cebra
                        opacity: 0.5
                    },
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " préstamos"
                        }
                    }
                }
            };

            var prestamosMesChart = new ApexCharts(
                document.querySelector("#prestamosPorMesChart"),
                prestamosMesOptions
            );
            prestamosMesChart.render();
        } else if (prestamosMesContainer) {
            // Si no hay datos, muestra un mensaje
            prestamosMesContainer.innerHTML =
                '<div class="text-center p-5 text-muted">No hay datos de préstamos para este año.</div>';
        }

        // --- Gráfico de Dona: Estado de Préstamos ---
        const estadoPrestamosContainer = document.querySelector("#estadoPrestamosChart");
        // Verificamos que el contenedor exista Y que el array de valores no esté vacío
        if (estadoPrestamosContainer && estadoPrestamosData.valores && estadoPrestamosData.valores.length > 0) {

            // --- INICIO CAMBIO: Mapeo de Colores ---
            const colorMap = {
                'Prestado': '#dc3545', // Rojo
                'Devuelto': '#198754', // Verde
                'Observado': '#ffc107', // Amarillo
                // Añade otros estados si los tienes
            };

            // Ordena el array de colores para que coincida con el array de etiquetas
            const orderedColors = estadoPrestamosData.labels.map(label => colorMap[label] ||
                '#6c757d'); // Gris como fallback
            // --- FIN CAMBIO ---

            var estadoPrestamosOptions = {
                chart: {
                    type: 'donut',
                    height: 350
                },
                series: estadoPrestamosData.valores,
                labels: estadoPrestamosData.labels,
                colors: orderedColors,
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true
                                },
                                value: {
                                    show: true,
                                    formatter: function(val) {
                                        return val
                                    }
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b
                                        }, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var estadoPrestamosChart = new ApexCharts(
                document.querySelector("#estadoPrestamosChart"),
                estadoPrestamosOptions
            );
            estadoPrestamosChart.render();
        } else if (estadoPrestamosContainer) {
            // Si no hay datos, muestra un mensaje
            estadoPrestamosContainer.innerHTML =
                '<div class="text-center p-5 text-muted">No hay datos de estados de préstamos.</div>';
        }

        // --- Gráfico de Barras Horizontales: Préstamos por Almacén ---
        const prestamosAlmacenContainer = document.querySelector("#prestamosPorAlmacenChart");
        // Verificamos que el contenedor exista Y que el array de valores no esté vacío
        if (prestamosAlmacenContainer && prestamosAlmacenData.valores && prestamosAlmacenData.valores.length > 0) {
            var prestamosAlmacenOptions = {
                chart: {
                    type: 'bar',
                    height: 350 + (prestamosAlmacenData.labels.length * 20),
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Préstamos',
                    data: prestamosAlmacenData.valores
                }],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 4,
                        distributed: true
                    }
                },
                colors: prestamosAlmacenData.labels.map((_, i) => {
                    const palette = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6f42c1',
                        '#fd7e14'];
                    return palette[i % palette.length];
                }),
                dataLabels: {
                    enabled: true,
                    style: {
                        colors: ['#000']
                    },
                    textAnchor: 'start'
                },
                xaxis: {
                    categories: prestamosAlmacenData.labels,
                    title: {
                        text: 'Cantidad de Préstamos'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Almacenes'
                    }
                },
                tooltip: {
                    y: {
                        formatter: val => val + ' préstamos'
                    }
                }
            };

            var prestamosAlmacenChart = new ApexCharts(
                document.querySelector("#prestamosPorAlmacenChart"),
                prestamosAlmacenOptions
            );
            prestamosAlmacenChart.render();

        } else if (prestamosAlmacenContainer) {
            // Si no hay datos, muestra un mensaje
            prestamosAlmacenContainer.innerHTML =
                '<div class="text-center p-5 text-muted">No hay datos de préstamos por almacén.</div>';
        }