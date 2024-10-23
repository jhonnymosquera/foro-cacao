let datosAnteriores = [];

function convertirASegundos(tiempo) {
    const [minutos, segundos] = tiempo.split(':').map(Number);
    return minutos * 60 + segundos;
}

function actualizarResultados(url) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('eventos-container');

            data.forEach((evento, indexEvento) => {
                let eventoElement = document.getElementById(`evento-${evento.evento_id}`);
                if (!eventoElement) {
                    eventoElement = document.createElement('div');
                    eventoElement.id = `evento-${evento.evento_id}`;
                    eventoElement.className = 'evento';
                    eventoElement.innerHTML = `<h2>Evento ${evento.evento_id}</h2>`;
                    container.appendChild(eventoElement);
                }

                // Ordenar equipos por tiempo (ascendente)
                evento.equipos.sort((a, b) => convertirASegundos(a.tiempo) - convertirASegundos(b.tiempo));

                const tiempoMaximo = convertirASegundos(evento.equipos[evento.equipos.length - 1].tiempo);

                evento.equipos.forEach((equipo, indexEquipo) => {
                    let equipoElement = document.getElementById(`equipo-${evento.evento_id}-${equipo.equipo_id}`);
                    const tiempoEquipo = convertirASegundos(equipo.tiempo);
                    const porcentaje = (tiempoEquipo / tiempoMaximo) * 100;

                    if (!equipoElement) {
                        equipoElement = document.createElement('div');
                        equipoElement.id = `equipo-${evento.evento_id}-${equipo.equipo_id}`;
                        equipoElement.className = 'equipo';
                        equipoElement.innerHTML = `
                            <div class="equipo-barra" style="width: ${porcentaje}%;"></div>
                            <span class="equipo-nombre">Equipos ${equipo.equipo_id}</span>
                            <span class="equipo-tiempo">Tiempo: ${equipo.tiempo}</span>
                        `;
                        eventoElement.appendChild(equipoElement);
                    } else {
                        const barraElement = equipoElement.querySelector('.equipo-barra');
                        const tiempoElement = equipoElement.querySelector('.equipo-tiempo');

                        barraElement.style.width = `${porcentaje}%`;
                        tiempoElement.textContent = `Tiempo: ${equipo.tiempo}`;
                    }

                    // Actualizar la posición del equipo
                    equipoElement.style.order = indexEquipo;
                });

                // Eliminar equipos que ya no están en los resultados
                const equiposActuales = new Set(evento.equipos.map(e => e.equipo_id));
                eventoElement.querySelectorAll('.equipo').forEach(el => {
                    const equipoId = parseInt(el.id.split('-')[2]);
                    if (!equiposActuales.has(equipoId)) {
                        el.remove();
                    }
                });
            });

            // Eliminar eventos que ya no están en los resultados
            const eventosActuales = new Set(data.map(e => e.evento_id));
            container.querySelectorAll('.evento').forEach(el => {
                const eventoId = parseInt(el.id.split('-')[1]);
                if (!eventosActuales.has(eventoId)) {
                    el.remove();
                }
            });

            // Actualizar datos anteriores para la próxima comparación
            datosAnteriores = data;
        })
        .catch(error => console.error('Error:', error));
}
