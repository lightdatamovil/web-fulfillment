<script>
    const globalExcel = (function() {
        public = {}

        public.leer = function(archivo) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                reader.onload = function(event) {
                    try {
                        const data = new Uint8Array(event.target.result);
                        const workbook = XLSX.read(data, {
                            type: 'array'
                        });

                        const resultado = {};

                        workbook.SheetNames.forEach(sheetName => {
                            const worksheet = workbook.Sheets[sheetName];
                            const json = XLSX.utils.sheet_to_json(worksheet, {
                                header: 1
                            });
                            resultado[sheetName] = json;
                        });

                        resolve(resultado);
                    } catch (error) {
                        reject(error);
                    }
                };

                reader.onerror = reject;
                reader.readAsArrayBuffer(archivo);
            });
        }

        // ! COMO USAR: 
        // public.subirExcel = async function() {
        // 	const archivo = $('#archivo_ordenesSubidaMasiva')[0].files[0];

        // 	if (archivo) {
        // 		try {
        // 			const datos = await globalExcel.leer(archivo);
        // 			g_data = datos;
        // 		} catch (err) {
        // 			globalSweetalert.error('Error al leer el archivo:', err);
        // 		}
        // 	} else {
        // 		globalSweetalert.error("Debe seleccionar un archivo para subir");
        // 	}
        // }

        public.crear = function(nombreArchivo, hojas) {
            const workbook = XLSX.utils.book_new();

            workbook.SheetNames = [];
            workbook.Sheets = {};

            for (const nombreHoja in hojas) {
                const datos = hojas[nombreHoja];
                const worksheet = XLSX.utils.aoa_to_sheet(datos);

                const colWidths = [];

                for (let fila of datos) {
                    fila.forEach((celda, i) => {
                        const contenido = celda ? String(celda) : '';
                        const longitud = contenido.length;
                        colWidths[i] = Math.max(colWidths[i] || 10, longitud + 2);
                    });
                }

                worksheet['!cols'] = colWidths.map(w => ({
                    wch: w
                }));

                XLSX.utils.book_append_sheet(workbook, worksheet, nombreHoja);
            }

            XLSX.writeFile(workbook, nombreArchivo);
        };



        return public;
    }())
</script>