# Variáveis
DOCKER_COMPOSE=docker-compose
DOCKER_BUILD=docker-compose build
DOCKER_UP=docker-compose up
DOCKER_DOWN=docker-compose down

# Arquivo de configuração do Nginx
NGINX_CONF_PATH=nginx

# Comandos para Desenvolvimento
dev:
	@echo "Iniciando ambiente de desenvolvimento..."
	@cp $(NGINX_CONF_PATH)/dev.conf ./nginx/default.conf
	@$(DOCKER_BUILD)
	@$(DOCKER_UP) --build -d

# Comandos para Produção
prod:
	@echo "Iniciando ambiente de produção..."
	@cp $(NGINX_CONF_PATH)/prod.conf ./nginx/default.conf
	@$(DOCKER_BUILD)
	@$(DOCKER_UP) --build -d

# Parar containers
down:
	@echo "Parando containers..."
	@$(DOCKER_DOWN)

# Limpeza dos containers e volumes
clean:
	@echo "Removendo containers e volumes..."
	@$(DOCKER_DOWN) -v

# Rebuild (construir novamente)
rebuild:
	@echo "Rebuilding containers..."
	@$(DOCKER_DOWN)
	@$(DOCKER_BUILD)
	@$(DOCKER_UP)
