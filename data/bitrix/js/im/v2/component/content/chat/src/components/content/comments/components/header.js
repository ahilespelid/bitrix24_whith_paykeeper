import { EventEmitter } from 'main.core.events';

import { EventType, ChatActionType } from 'im.v2.const';
import { AvatarSize, ChatAvatar } from 'im.v2.component.elements';
import { PermissionManager } from 'im.v2.lib.permission';

import { ChatHeader } from '../../base/components/chat-header/chat-header';
import { SubscribeToggle } from './subscribe-toggle';

import '../css/header.css';

import type { ImModelChat } from 'im.v2.model';

// @vue/component
export const CommentsHeader = {
	name: 'CommentsHeader',
	components: { ChatHeader, ChatAvatar, SubscribeToggle },
	props:
	{
		dialogId: {
			type: String,
			default: '',
		},
		channelId: {
			type: String,
			required: true,
		},
		currentSidebarPanel: {
			type: String,
			default: '',
		},
	},
	computed:
	{
		AvatarSize: () => AvatarSize,
		channel(): ImModelChat
		{
			return this.$store.getters['chats/get'](this.channelId, true);
		},
		showSubscribeToggle(): boolean
		{
			return PermissionManager.getInstance().canPerformAction(ChatActionType.subscribeToComments, this.dialogId);
		},
	},
	methods:
	{
		onBackClick()
		{
			EventEmitter.emit(EventType.dialog.closeComments);
		},
		loc(phraseCode: string): string
		{
			return this.$Bitrix.Loc.getMessage(phraseCode);
		},
	},
	template: `
		<ChatHeader
			:dialogId="dialogId"
			:currentSidebarPanel="currentSidebarPanel"
			class="bx-im-comment-header__container"
		>
			<template #left>
				<div @click="onBackClick" class="bx-im-comment-header__back"></div>
				<div class="bx-im-comment-header__info">
					<div class="bx-im-comment-header__title">{{ loc('IM_CONTENT_COMMENTS_HEADER_TITLE') }}</div>
					<div class="bx-im-comment-header__subtitle">
						<div class="bx-im-comment-header__subtitle_avatar">
							<ChatAvatar :avatarDialogId="channelId" :contextDialogId="channelId" :size="AvatarSize.XS" />
						</div>
						<div class="bx-im-comment-header__subtitle_text">{{ channel.name }}</div>
					</div>
				</div>
			</template>
			<template v-if="showSubscribeToggle" #before-actions>
				<SubscribeToggle :dialogId="dialogId" />
			</template>
		</ChatHeader>
	`,
};
