pipeline {
    agent any

    environment {
        IMAGE_NAME = "shivanisable/pg-booking"
        CONTAINER_NAME = "pg-app"
        DB_CONTAINER = "pg-db"
    }

    stages {

        stage('Clone Code') {
            steps {
                git branch: 'main', url: 'https://github.com/shivanisable13/rent_pag.git'
            }
        }

        stage('Stop Old Containers') {
            steps {
                sh '''
                docker rm -f $CONTAINER_NAME || true
                docker rm -f $DB_CONTAINER || true
                '''
            }
        }

        stage('Create Network') {
            steps {
                sh 'docker network create pg-network || true'
            }
        }

        stage('Run MySQL') {
            steps {
                sh '''
                docker run -d \
                --name $DB_CONTAINER \
                --network pg-network \
                -e MYSQL_ROOT_PASSWORD=root \
                -e MYSQL_DATABASE=pg_rental \
                mysql:5.7
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Run App Container') {
            steps {
                sh '''
                docker run -d \
                --name $CONTAINER_NAME \
                --network pg-network \
                -p 80:80 \
                $IMAGE_NAME
                '''
            }
        }
    }
}
