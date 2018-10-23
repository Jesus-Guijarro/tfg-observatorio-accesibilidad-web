import json


####Hay que posicionarse

data = {
oaw: {
	fecha: "2015-09-07T22:03:02.741-05:00",
	resultado: {
		elementos: {
			formularios: 1,
			iframes: 0,
			imagenes: 43,
			links: 159,
			linksImagen: 34,
			objects: 0,
			tablas: 11,
			total: 770
		},
		imagen: "http://observatorio.ups.edu.ec/oaw/...",
		nivel: "AAA",
		principios: [
			{
				numero: 1,
				titulo: "Perceptible",
				descripcion: "La información y los ...",
				pautas: [
					{
						numero: "1.1.",
						descripcion: "Proporcionar alternativas textuales ...",
						titulo: "Alternativas textuales",
						criterioCumplimientos: {
						numero: "1.1.1.",
						nivel: "A",
						titulo: "Contenido no textual...",
						criterioExitos: [
							{
								codigo: "H24",
								criticidad: "Alta",
								titulo: "Proporcionar t...",
								incidencias: 16,
								exitos: 3,
								errores: 16,
								observacion: "De los 19 elementos...",
								recomendacion: "Se debe aplicar ...",
								clasificacion: "Error"
							},
							{
								codigo: "H35",
								criticidad: "Alta",
								titulo: "Proporcionando t...",
								incidencias: 0,
								exitos: 0,
								errores: 0,
								observacion: "Se recomienda colocar ...",
								recomendacion: "Todos los ap...",
								clasificacion: "Advertencia"
							},
							/* De más criterios que permiten verificar el criterio de cumplimiento*/
						]
					},
					/* De más pautas ...*/
				]
			},
			/* De más principios ...*/
		],
		resolucion: "1366x768",
		resumen: {
			comprensible: {
				advertencias: 5,
				errores: 3,
				exitos: 5,
				noaplica: 0
			},
			operable: {
				advertencias: 2,
				errores: 3,
				exitos: 4,
				noaplica: 3
			},
			perceptible: {
				advertencias: 17,
				errores: 11,
				exitos: 6,
				noaplica: 4
			},
			robusto: {
				advertencias: 2,
				errores: 1,
				exitos: 1,
				noaplica: 0
			},
			"totalComprensible": "76%",
			"totalOperable": "66%",
			"totalPerceptible": "67%",
			"totalRobusto": "75%"
		},
		"url": "http://dominio.com/mipagina.html"
	}
	}
}

data_string = json.dumps(data)

decode = json.loads(data_string)

d = decode["categories"]["error"]["items"]

valores = d.values()
claves = d.keys()

for v in valores:
    print(str(v["description"]) +" -- "+ str(v["count"]))

