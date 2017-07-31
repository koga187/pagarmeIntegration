# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = 'bento/ubuntu-16.04'
  config.vm.network "private_network", ip: "172.28.128.18"
  config.vm.hostname = "pagarme.test"
  config.vm.synced_folder './', '/var/www/pagarme', owner:"www-data", group:"www-data"
  config.vm.provision "shell", path: "./server_provision.sh"

  config.vm.provider "virtualbox" do |pagarme|
    pagarme.customize ["modifyvm", :id, "--memory", "512"]
  end

end