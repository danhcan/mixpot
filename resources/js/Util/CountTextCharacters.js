import {parse as extractEmojiWithIndices} from 'twemoji-parser';

const getLength = (text, config = []) => {
    const $config = {
        ...{
            urlWeight: null,
            emojiWeight: 2,
        },
        ...config
    };

    if (typeof text !== 'string') {
        throw new TypeError('Invalid input: text must be a string.');
    }

    const chars = text.split('');
    let weightedLength = 0;

    const emojiEntitiesMap = $config.emojiWeight ? transformEntitiesToHash(extractEmojiWithIndices(text)) : [];
    const invalidCharRegex = /[^\u0009-\u000D\u0020-\uFFFF]/u;

    for (let i = 0; i < chars.length; i++) {
        const char = chars[i];

        if (invalidCharRegex.test(char)) {
            continue;
        }

        if ($config.emojiWeight && emojiEntitiesMap[i]) {
            const emojiEntityMapCharacter = emojiEntitiesMap[i];
            weightedLength += $config.emojiWeight;
            i += emojiEntityMapCharacter.text.length - 1;
        } else {
            weightedLength += 1;
        }
    }

    return weightedLength;
};

const transformEntitiesToHash = (entities) => {
    return entities.reduce(function (map, entity) {
        map[entity.indices[0]] = entity;
        return map;
    }, {});
};

export default {
    getLength
}
