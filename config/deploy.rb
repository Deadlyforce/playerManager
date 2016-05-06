# config valid only for current version of Capistrano
lock '3.5.0'

set :application, 'Mnaomai'
set :repo_url, 'https://github.com/Deadlyforce/playerManager.git'

# Default value for :linked_files is []
set :linked_files, %w{app/config/parameters.yml}

# Default value for linked_dirs is []
set :linked_dirs, %w{var/logs vendor web/vendor web/assets}

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :airbrussh.
set :format, :pretty

set :log_level, :debug

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: 'log/capistrano.log', color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true


# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 5

after 'deploy:starting', 'composer:install_executable'
after 'deploy:updated', 'symfony:assets:install'
after 'deploy:updated', 'symfony:assetic:dump'

# namespace :deploy do

  # after :restart, :clear_cache do
    # on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    # end
  # end

# end
