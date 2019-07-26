.PHONY : default init

define INITMESSAGE
======================================================================

 run make<tab> to see a list of all possible target commands
below echos the description and example usages of all targets
make has TAB COMPLETION so you can type 'make te<tab>' and get make test for example

======================================================================

endef
export INITMESSAGE
default:
	@echo "$$INITMESSAGE"
	@grep 'CMD\|USAGE' Makefile | sed -e 's/"//g; s/@echo//g; /@grep/d; s/USAGE:/    USAGE:/g'
composer:
	@echo "CMD: 'make composer c=install'  (OR update) to run composer commands inside the vagrant vm"
	@echo "USAGE: Run 'make composer c=install'  (OR update) to run composer commands inside the vagrant vm"
	@echo $(c)
	docker-compose run zf composer $(c)
up:
	@echo "CMD: make up"
	@echo "USAGE: brings docker-compose up "
	docker-compose up -d --build
	open http://localhost:8025/
	open http://localhost:8080/
down:
	@echo "CMD: make down"
	@echo "USAGE: destroys the docker containers and volumes"
	docker-compose down
