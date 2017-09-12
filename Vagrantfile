# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"
confDir = $confDir ||= File.expand_path("vendor/laravel/homestead", File.dirname(__FILE__))

homesteadYamlPath = "Homestead.yaml"
homesteadJsonPath = "Homestead.json"
afterScriptPath = "after.sh"
aliasesPath = "aliases"

require File.expand_path(confDir + '/scripts/homestead.rb')

Vagrant.require_version '>= 1.9.0'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    if File.exist? aliasesPath then
        config.vm.provision "file", source: aliasesPath, destination: "/tmp/bash_aliases"
        config.vm.provision "shell" do |s|
            s.inline = "awk '{ sub(\"\r$\", \"\"); print }' /tmp/bash_aliases > /home/vagrant/.bash_aliases"
        end
    end

    if File.exist? homesteadYamlPath then
        settings = YAML::load(File.read(homesteadYamlPath))
    elsif File.exist? homesteadJsonPath then
        settings = JSON.parse(File.read(homesteadJsonPath))
    else
        abort "Homestead settings file not found in #{confDir}"
    end

    Homestead.configure(config, settings)

    config.vm.provision "shell", inline: <<-SHELL
      echo 'Installing updates'
      apt-get update
      echo 'Installing JDK'
      apt-get install -y openjdk-8-jdk
      echo 'Installing xdebug'
      pecl install xdebug
      echo 'zend_extension=/usr/lib/php/20160303/xdebug.so' >> /etc/php/7.1/cli/php.ini
      echo 'zend_extension=/usr/lib/php/20160303/xdebug.so' >> /etc/php/7.1/fpm/php.ini
      service php7.1-fpm restart
    SHELL

    config.vm.provision "shell", privileged: false, inline: <<-SHELL
      echo 'Installing Elasticsearch'
      wget --no-verbose https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-5.4.0.tar.gz > /dev/null
      tar -xzf elasticsearch-*.tar.gz
      mv elasticsearch-5.4.0 elasticsearch
      rm elasticsearch-*
    SHELL

    if File.exist? afterScriptPath then
        config.vm.provision "shell", path: afterScriptPath, privileged: false
    end

    if defined? VagrantPlugins::HostsUpdater
        config.hostsupdater.aliases = settings['sites'].map { |site| site['map'] }
    end
end
