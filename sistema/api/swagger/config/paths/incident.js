export const incident = {
    "get": {
        "tags": [
            "Incident"
        ],
        "summary": "Obter incidentes",
        "parameters": [
            {
                "in": "header",
                "name": "Authorization",
                "description": "Token de autenticação",
                "schema": {
                    "type": "string"
                }
            },
            {
                "in": "query",
                "name": "isOpen",
                "schema": {
                    "type": "boolean"
                }
            }
        ],
        "description": "Esta rota retorna uma lista de incidentes.",
        "responses": {
            "200": {
                "description": "Requisição bem-sucedida",
                "content": {
                    "application/json": {
                        "schema": {
                            "type": "array",
                            "items": {
                                "type": "object",
                                "properties": {
                                    "id": {
                                        "type": "integer"
                                    },
                                    "incident": {
                                        "type": "string"
                                    },
                                    "eventId": {
                                        "type": "integer"
                                    },
                                    "isOpen": {
                                        "type": "boolean"
                                    },
                                    "closeDate": {
                                        "type": "string",
                                        "format": "date-time"
                                    },
                                    "integrationcode": {
                                        "type": "string"
                                    },
                                    "incidentType": {
                                        "type": "string"
                                    },
                                    "more": {
                                        "type": "json"
                                    },
                                    "createdAt": {
                                        "type": "string",
                                        "format": "date-time"
                                    },
                                    "updatedAt": {
                                        "type": "string",
                                        "format": "date-time"
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
