# Get sami.phar
wget http://get.sensiolabs.org/sami.phar

# Generate Api
php sami.phar update sami.php
cd ../gh-pages

# Set identity
git config --global user.email "travis@travis-ci.org"
git config --global user.name "Travis"

# Add branch
git init
git remote add origin https://${GH_TOKEN}@github.com/elcodi/elcodi.git > /dev/null
git checkout -B gh-pages
git rm -rf .

# Push generated files
git add --all .
git commit -m "API updated"
git push origin gh-pages -fq > /dev/null
