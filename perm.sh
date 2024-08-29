#!/bin/bash

chmod -R 755 cloud_share
echo "Права изменены."
chown -R apache:apache cloud_share
echo "Владелец изменен."
