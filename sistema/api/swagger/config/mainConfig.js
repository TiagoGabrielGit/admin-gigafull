import { incident } from "./paths/incident.js"
export const config = {
    info: {
        version: "3.0.0",
        title: "Api-Hub",
        description: "This is the official Api-hub documentation",
        contact: {
            "name": "suporte@mundovoa",
            "email": "suporte@mundovoa.com"
        },
        servers: [
            "http://localhost:3000"
        ]
    },
    schemes: [
        "http",
        "https"
    ],
    securitySchemes: {
        "api_key": {
            "type": "apiKey",
            "name": "api_key",
            "in": "header"
        }
    },
    swagger: "2.0",
    paths: {
        "/incident": incident
    },
    "definitions": {},
    "responses": {},
    "parameters": {},
    "securityDefinitions": {},
    "tags": []
}