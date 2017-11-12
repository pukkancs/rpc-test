FROM php:7.1-fpm

# Get repository and install wget and vim
RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        unzip

# Install Composer
RUN curl -s https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer


# Clean repository
RUN apt-get clean \
&& rm -rf /var/lib/apt/lists/*