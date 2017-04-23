#!/bin/sh

EXITCODE=0

check() {
    if [ ${EXITCODE} -gt 0 ]; then
        echo
        echo '\033[1;41;37mFix the above errors or use:\033[0m'
        echo '  git commit --no-verify'
        echo

        exit ${EXITCODE}
    fi
}

composer static
if [ $? != 0 ]; then
    EXITCODE=1
fi
check

composer tests;
if [ $? != 0 ]; then
    EXITCODE=1
fi
check

exit ${EXITCODE}
