pipeline {
    agent any

    environment {
        IMAGE_NAME = "shivanisable/pg-booking"
        APP_CONTAINER = "pg-app"
        DB_CONTAINER = "pg-db"
    }

    stages {

        stage('Clone Code') {
            steps {
                git branch: 'main', url: 'https://github.com/shivanisable13/rent_pag.git'
            }
        }

        stage('Cleanup Old Containers') {
            steps {
                sh '''
                docker rm -f $APP_CONTAINER || true
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

        stage('Wait for MySQL') {
            steps {
                sh 'sleep 20'
            }
        }

        stage('Import Database') {
            steps {
                sh '''
                docker exec -i $DB_CONTAINER mysql -uroot -proot pg_rental < config/database.sql
                '''
            }
        }

        stage('Build App Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Run App Container') {
            steps {
                sh '''
                docker run -d \
                --name $APP_CONTAINER \
                --network pg-network \
                -p 80:80 \
                $IMAGE_NAME
                '''
            }
        }
    }
}
