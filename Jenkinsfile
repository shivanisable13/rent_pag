pipeline {
    agent any

    environment {
        IMAGE_NAME = "shivanisable/pg-booking"
    }

    stages {

        stage('Clone Code') {
            steps {
                git branch: 'main', url: 'https://github.com/shivanisable13/rent_pag.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Stop Old Container') {
            steps {
                sh 'docker rm -f pg-app || true'
            }
        }

        stage('Run New Container') {
            steps {
                sh '''
                docker run -d \
                --name pg-app \
                --network pg-network \
                -p 80:80 \
                $IMAGE_NAME
                '''
            }
        }
    }
}
